<?php

namespace Drupal\cact_openbravo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\cact_openbravo\CactServicesUtils;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CactWebservicesEndpointController extends ControllerBase {

  /**
   * The cache menu instance.
   *
   * @var \Drupal\cact_openbravo\CactServicesUtils
   */
  protected $cactServicesUtils;


  /**
   * Constructs a ToolbarController object.
   *
   * @param \Drupal\cact_openbravo\CactServicesUtils $cactServicesUtils
   *   A menu link manager instance.
   */
  public function __construct(CactServicesUtils $cact_services_utils ) {
    $this->cactServicesUtils = $cact_services_utils;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cact_openbravo.cact_services_utils')
    );
  }  
  
  /**
   * getStocksEndpoint
   *
   * @param  mixed $product_id
   * @param  mixed $datefrom
   * @param  mixed $dateto
   * @param  mixed $detailed
   * @return void
   */
  public function getStocksEndpoint($product_id, $datefrom, $dateto, $detailed) {
    $query_dates = [
        'datefrom' => $datefrom,
        'dateto' => $dateto
    ];
    $data_calendar = $this->cactServicesUtils->getDataStocks($product_id, null, $query_dates, $detailed);
    $data = [];
    if (!empty($data_calendar) && isset($data_calendar['result']['dates'])){
      $data = $data_calendar;
    }
    // Puedes acceder a los parámetros recibidos desde la URL.
    

    // Devuelve una JsonResponse con los parámetros en formato JSON.
    return new JsonResponse($data);
  }
}
