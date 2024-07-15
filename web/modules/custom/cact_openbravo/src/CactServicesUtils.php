<?php

namespace Drupal\cact_openbravo;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;


/**
 * Class CactServicesUtils
 *
 * @package Drupal\cact_openbravo
 */
class CactServicesUtils {


  /**
   * Openbravo services.
   *
   * @var \Drupal\cact_openbravo\CactOpenbravoServices
   */
  protected $cactOpenbravoServices;

  /**
   * @var \Drupal\Core\Config\Config Cact Openbravo settings
   */
  protected $config  = NULL;

  /**
   * CactOpenbravoEntityHandler constructor.
   * @param CactOpenbravoServices $cact_openbravo_services
   * @param ConfigFactoryInterface $config
   */
  public function __construct(CactOpenbravoServices $cact_openbravo_services, ConfigFactoryInterface $config)
  {
    $this->cactOpenbravoServices = $cact_openbravo_services;
    $this->config = $config->get('cact_openbravo.settings');
  }
  
  /**
   * AddFourMonthsFrom
   * takes a number of months as a parameter, adds that number of 
   * months to the current date, and then returns the last day of 
   * the resulting month in 'YYYY-MM-DD' forma
   *
   * @param  int $start_date
   * @param  int $months_to_add
   * @param  string $format_date
   * @return array
   */
  public function AddFourMonthsFrom($start_date = null, $months_to_add = 4): array {
    $start_date = $start_date ? $start_date : time();
    $fechaHoy = DrupalDateTime::createFromTimestamp($start_date);
    $formatted_date = $fechaHoy->format('Y-m-d');

    // Add 4 months to today's date
    $fechaResultado = $fechaHoy->modify("+$months_to_add months");

    // Get the date formatted in the desired format
    $fechaFormateada = $fechaResultado->format('Y-m-t');
    return [
      'datefrom' => $formatted_date,
      'dateto' => $fechaFormateada
    ];
  }
  
  /**
   * getDataStocks
   *  consult the Stocks service and return a structure to layout the calendar
   *
   * @param  string $first_sku
   *  code sku
   * @param  int $date_ref
   *  Remove sessions from field release hours
   * @param  array $query_dates
   *  parameters to consult the service
   * @param  string $detailed
   *  A string must be sent with the value of true or false that is responsible for returning the timeSlots field
   * @return array
   */
  public function getDataStocks($first_sku, $date_ref, $query_dates =  [], $detailed = 'false') : array {
    $data_calendar = [];
    $query['productId'] = $first_sku;
    // Lo primero que hay que definir es la fecha de inicio para el endpoint
    // Esa fecha vendrá dada por la fecha de hoy

    // La fecha de fin será la desde la fecha de hoy, contar 4 meses y obtendremos el último día de ese mes como fecha de fin.
    $query_dates = (!empty($query_dates)) ? $query_dates : $this->AddFourMonthsFrom();
    if ((!empty($query_dates))) {
        $query = array_merge($query, $query_dates);
    }
    
    $query['detailed'] = $detailed;// send the value as a string 'false' o 'true'
    $request  = $this->cactOpenbravoServices->getStocks(null, $query);
    if($request && isset($request['response']['status_code']) && $request['response']['status_code'] === 200 && isset($request['data']['result']['dates'])) {
      $results_sessions = $request['data']['result']['dates'];
      $data_calendar['success'] = $request['response']['status_code'] === 200 ? true : false;
      $data_calendar['result']['productID'] = $request['data']['result']['productId'];
      $data_calendar['result']['productName'] = $request['data']['result']['productName'];

      if (!is_null($date_ref)) {
        foreach ($results_sessions as $index => $rs):
          if (isset($rs['date']) && strtotime($rs['date']) <= $date_ref) {
            unset($results_sessions[$index]);
          } else {
            $row = [
              "date" => $rs['date'],
              "totalqty" => $rs['totalQty'],
            ];
            if (isset($rs['timeSlots'])) {
              $row['timeSlots'] = $rs['timeSlots'];
            }
            $data_calendar['result']['dates'][] = $row;
          }
        endforeach;
        $results_sessions = array_values($results_sessions);
      } else {
        foreach ($results_sessions as $index => $rs):
         // $date_calendar = explode( ' ', $rs['sessionDate']);
          $row = [
            "date" => $rs['date'],
            "totalqty" => $rs['totalQty'],
          ];
          if (isset($rs['timeSlots'])) {
            $row['timeSlots'] = $rs['timeSlots'];
          }
          $data_calendar['result']['dates'][] = $row;

        endforeach;
      }
    }
    return $data_calendar;
  }
  
  /**
   * getMonthNames
   *  returns the months of the year
   *
   * @return array
   */
  public function getMonthNames(): array {
    $language_manager = \Drupal::languageManager();
    $user_language = $language_manager->getCurrentLanguage()->getId();
    $date_formatter = \Drupal::service('date.formatter');
    $months = array();
    for ($month = 1; $month <= 12; $month++) {
      $timestamp = mktime(0, 0, 0, $month, 1);
      $formatted_month = $date_formatter->format($timestamp, 'custom', 'F', NULL, $user_language);
      $months[] = $formatted_month;
    }
    return $months;
  } 
  
}