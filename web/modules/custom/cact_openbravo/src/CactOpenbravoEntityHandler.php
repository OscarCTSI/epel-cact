<?php

namespace Drupal\cact_openbravo;

use Drupal\cact_general\CactOrderUtility;
use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Mail\MailManagerInterface;

/**
 * Class CactOpenbravoEntityHandler
 *
 * @package Drupal\cact_openbravo
 */
class CactOpenbravoEntityHandler
{

  /**
   * Openbravo services.
   *
   * @var \Drupal\cact_openbravo\CactOpenbravoServices
   */
  protected $cactOpenbravoServices;

  /**
   * Utities for order
   *
   * @var \Drupal\cact_general\CactOrderUtility
   */
  protected $cactOrderUtility;

  /**
   * @var \Drupal\Core\Config\Config Cact Openbravo settings
   */
  protected $config  = NULL;

  /**
   * Mail manager service.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * CactOpenbravoEntityHandler constructor.
   * @param CactOpenbravoServices $cact_openbravo_services
   * @param CactOrderUtility $cact_order_utility
   * @param ConfigFactoryInterface $config
   * @param MailManagerInterface $mail_manager
   */
  public function __construct(CactOpenbravoServices $cact_openbravo_services, CactOrderUtility $cact_order_utility,
                              ConfigFactoryInterface $config, MailManagerInterface $mail_manager)
  {
    $this->cactOpenbravoServices = $cact_openbravo_services;
    $this->cactOrderUtility = $cact_order_utility;
    $this->config = $config->get('cact_openbravo.settings');
    $this->mailManager = $mail_manager;
  }

  /**
   * Add prereserve
   *
   * @param Drupal\commerce_order\Entity\OrderItemInterface $order_item
   *
   * @return boolean
   */
  public function setPrereserve(OrderItemInterface $order_item)
  {
    $dev = true;
    $commerce_product = $order_item->getPurchasedEntity()->getProduct();
    $product_event_type = $commerce_product->get('field_event_type')->value;
    if (($product_event_type == 1 && !$order_item->get('field_session')->isEmpty()) ||
      ($product_event_type == 2 && !$order_item->get('field_session')->isEmpty() &&
        !$order_item->get('field_location')->isEmpty()) ||
        ($product_event_type == 3 && !$order_item->get('field_time_slot_id')->isEmpty())) {
      $data = [];
      
      if ($product_event_type == 3) {
        $data['timeSlotDetailId'] = $order_item->get('field_time_slot_id')->value;
      } else {
        $data['sessionId'] = $order_item->get('field_session')->value;
      }    

      if ($product_event_type == 1) {
        $data['qty'] = $order_item->getQuantity();
      }
      else if($product_event_type == 3){
        $date = explode(' ', $order_item->get('field_ticket_date')->value);
        $data['date'] = $date[0];
        $data['qty'] = $order_item->getQuantity();
      } 
      else {
        $data['locationNo'] = $order_item->get('field_location')->value;
        $data['prereserve'] = true;
      }
      
      if(empty($this->config->get('cact_openbravo.no_integration')) || !$this->config->get('cact_openbravo.no_integration')) {
        $prereserve = $this->cactOpenbravoServices->createPrereserve($data);
        if ($product_event_type == 1 && isset($prereserve['data']['result']['reservationId'])) {
          $order_item->set('field_reservation_id', $prereserve['data']['result']['reservationId']);
          $order_item->save();
        } 
        else if ($product_event_type == 3 && isset($prereserve['data']['result']['reservationId'])) {
          $order_item->set('field_reservation_id', $prereserve['data']['result']['reservationId']);
          $order_item->save();
        }
        else if ($product_event_type != 2) {
          $order_item->delete();
          $dev = false;
        }
      }
    }
    return $dev;
  }
  /**
   * Remove prereserve
   *
   * @param Drupal\commerce_order\Entity\OrderItemInterface $order_item
   *
   * @return boolean
   */
  public function removePrereserve(OrderItemInterface $order_item) {
    $dev = false;
    $commerce_product = $order_item->getPurchasedEntity()->getProduct();
    $product_event_type = $commerce_product->get('field_event_type')->value;
    if(($product_event_type == 1 && !$order_item->get('field_session')->isEmpty() &&
        !$order_item->get('field_reservation_id')->isEmpty()) || ($product_event_type == 2 &&
        !$order_item->get('field_session')->isEmpty() && !$order_item->get('field_location')->isEmpty())
        
        ){
      $data = [];
      $data['sessionId'] = $order_item->get('field_session')->value;
      if($product_event_type == 1){
        $data['reservationId'] = $order_item->get('field_reservation_id')->value;
        $data['qty'] = 0;
      }
      else if($product_event_type == 3){
        $data['detailTimeSlotsId'] = $order_item->get('field_time_slot_id')->value;
        $data['date'] = $order_item->get('field_ticket_date')->value;
        $data['reservationId'] = $order_item->get('field_reservation_id')->value;
        $data['qty'] = 0;
      }
      else{
        $data['locationNo'] = $order_item->get('field_location')->value;;
        $data['prereserve'] = false;
      }
      if(empty($this->config->get('cact_openbravo.no_integration')) || !$this->config->get('cact_openbravo.no_integration')) {
        $prereserve = $this->cactOpenbravoServices->createPrereserve($data);
      }
      $dev = true;
    }

    return $dev;
  }

  /**
   * Set Order
   *
   * @param Drupal\commerce_order\Entity\OrderInterface $order
   *
   * @return boolean
   */
  public function setOrder(OrderInterface $order) {
    $dev = true;
    $address = $order->getBillingProfile()->get('address');
    $tomaticket_id = 0;
    $lines = [];
    foreach($order->getItems() as $order_item):
      $commerce_product = $order_item->getPurchasedEntity()->getProduct();
      $product_event_type = $commerce_product->get('field_event_type')->value;
      $line = [
        "productId" => $order_item->getPurchasedEntity()->getSku(),
        "qty" => $order_item->getQuantity(),
        "grossPrice" => $order_item->getUnitPrice()->getNumber()
      ];
      if($product_event_type == 3){
        $line['detailTimeSlotsId'] = $order_item->get('field_time_slot_id')->value;
        $line['date'] = $order_item->get('field_ticket_date')->value;
      }
      $passNumbers = [];
      $order_items_codes = $this->cactOrderUtility->getOrderItemCode($order_item);
      foreach($order_items_codes as $oic):
        $passNumbers[] = $oic['value'];
      endforeach;

      $line['passNumbers'] = $passNumbers;

      if($product_event_type == 2){
        $line['locationsNo'] = $order_item->get('field_location')->value;
      }

      if(!$order_item->get('field_session')->isEmpty()){
        $line['sessionId'] = $order_item->get('field_session')->value;
      }
      if(!$order_item->get('field_reservation_id')->isEmpty()){
        $line['reservationId'] = $order_item->get('field_reservation_id')->value;
      }
      
      $lines[] = $line;
    endforeach;

    $sandbox = $this->config->get('cact_openbravo.sandbox');
    $payments_gateways = $this->config->get('cact_openbravo.payments_gateways');
    if ($order->getTotalPrice()->isZero()) {
      $tomaticket_id = $order->id();
      $paymentMethodCode = 'Gratis';//todo freee
    }
    else {
      $tomaticket_id = $order->getOrderNumber();
      $paymentMethodCode = ($payments_gateways[$order->get('payment_gateway')->getString()])??'';
    }
    $reference = '';

    if(!$order->get('field_reference_redsys')->isEmpty()) {
      $reference = $order->get('field_reference_redsys')->getString();
    }else if(!$order->get('field_reference_paypal')->isEmpty()) {
      $reference = $order->get('field_reference_paypal')->getString();
    }

    // Get payed date if the order is paid, else get current date
    $dateFormat = 'Y-m-d H:i:s';
    $date_completed_order = $order->getCompletedTime();
    if ($order->isPaid() && isset($date_completed_order)):
      $dateOrdered = DrupalDateTime::createFromTimestamp($date_completed_order)->format($dateFormat);
    else:
      $now = new \DateTime('NOW');
      $dateOrdered = DrupalDateTime::createFromTimestamp($now->getTimestamp())->format($dateFormat);
    endif;

    $data = [
      "tomaticketId" => $tomaticket_id,
      "dateOrdered" => $dateOrdered,
      "reference" => $reference,
      "customer" => [
        "name" => ($sandbox['sandbox_enable'])?$sandbox['customer_name']:$address->getValue()[0]['given_name'] . ' ' . $address->getValue()[0]['family_name'],
        "fiscalName" => ($sandbox['sandbox_enable'])?$sandbox['customer_fiscal_name']:$address->getValue()[0]['organization'],
        "taxid" => ($sandbox['sandbox_enable'])?$sandbox['customer_tax_id']:"",
        "address" => ($sandbox['sandbox_enable'])?$sandbox['customer_address_line1']:$address->getValue()[0]['address_line1'],
        "address2" => ($sandbox['sandbox_enable'])?$sandbox['customer_address_line2']:$address->getValue()[0]['address_line2'],
        "postal" => ($sandbox['sandbox_enable'])?$sandbox['customer_postal_code']:$address->getValue()[0]['postal_code'],
        "city" => ($sandbox['sandbox_enable'])?$sandbox['customer_city']:$address->getValue()[0]['administrative_area'],
        "regionCode" => ($sandbox['sandbox_enable'])?$sandbox['customer_region_code']:substr($address->getValue()[0]['postal_code'], 0, 2),
        "countryCode" => ($sandbox['sandbox_enable'])?$sandbox['customer_country_code']:$address->getValue()[0]['country_code']
      ],
      "grossAmount" => $order->getTotalPrice()->getNumber(),
      "paymentMethodCode" => $paymentMethodCode,
      "lines" => $lines
    ];
    
    if(empty($this->config->get('cact_openbravo.no_integration')) || !$this->config->get('cact_openbravo.no_integration')) {
      $request = $this->cactOpenbravoServices->order($data);
      \Drupal::logger('cact_openbravo')->info('Openbravo request info for ' . $tomaticket_id . ': ' .  print_r($request, true));
    
      if(!isset($request['data']['success']) || $request['data']['success'] != true){
        // Send email with errors
        $mails = $this->config->get('cact_openbravo.mails');
        $mails = explode(',', $mails);
        if(!empty($mails)){
          $module = 'cact_openbravo';
          $key = 'openbravo_problems';
          $params['subject'] = t('Problem inserting the order @order_number in openbravo.', ['@order_number' => $tomaticket_id]);
          $params['body'] = t('Openbravo error for @order_number: <br />Send data from drupal: <pre>@data</pre><br />Response data from Openbravo:<pre>@error</pre>', ['@order_number' => 'test', '@data' => print_r($data, true), '@error' => print_r($request, true)]);
          foreach($mails as $to):
            $result = $this->mailManager->mail($module, $key, $to, 'es', $params, NULL, true);
            if ($result['result'] != true) {
              $message = t('There was a problem sending your email notification to @email.', ['@email' => $to]);
              \Drupal::logger('cact_openbravo')->error($message);
            }
          endforeach;
        }
        \Drupal::logger('cact_openbravo')->error('Openbravo request error for ' . $tomaticket_id . ': ' .  print_r($request, true));
        $dev = false;
      }else{
        $order_ref = Order::load($order->id());
        $order_ref->set('field_reference_openbravo', $request['data']['order']['documentNo'])->save();
      }
    }

    return $dev;
  }

  public function listImplodes($matriz) {
    $subarrays = array_map(function($subarray) {
      return implode(',', $subarray);
    }, $matriz);
    $resultado = implode(',', $subarrays);
    return $resultado;
  }
}
