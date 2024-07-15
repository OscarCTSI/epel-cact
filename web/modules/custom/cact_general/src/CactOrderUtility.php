<?php

namespace Drupal\cact_general;

use CommerceRedsys\Payment\Sermepa as SermepaApi;
use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_order\Entity\Order;
use Drupal\commerce_order\Entity\OrderItem;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\commerce_price\RounderInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Drupal\Core\Render\RendererInterface;
use Drupal\commerce_payment\Entity\PaymentGateway;
use Drupal\commerce_payment\Entity\PaymentMethod;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Class CactOrderUtitlity
 *
 * @package Drupal\cact_general
 */
class CactOrderUtility
{
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The rounder.
   *
   * @var \Drupal\commerce_price\RounderInterface
   */
  protected $rounder;

  /**
   * The object renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;


  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * CactOrderUtility constructor.
   * @param EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountInterface $current_user)
  {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }


  public function setLocatorsCode(OrderInterface $order): OrderInterface
  {
    $order_items = $order->getItems();
    $i = 1;
    foreach($order_items as $order_item):
      if(!$order_item->field_locators_code->isEmpty()){
        $order_item->field_locators_code->setValue([]);
      }
      for($j = 0; $j < $order_item->getQuantity(); $j++){
        $code = $order->getOrderNumber() . str_pad($i, 4, "0", STR_PAD_LEFT);
        $order_item->field_locators_code->appendItem($code);
        $i++;
      }
      $order_item->save();
    endforeach;

    return $order;
  }

  /**
   * Get the item order code
   * */
  public function getOrderItemCode(OrderItemInterface $order_item, $with_names = false): Array
  {
    $locators_code = $order_item->get('field_locators_code')->getValue();
    if($with_names && !$order_item->get('field_name')->isEmpty()){
      foreach($locators_code as &$lc):
        $lc['name'] = $order_item->get('field_name')->getString();
      endforeach;
    }

    return $locators_code;
  }

  /**
   * Get the item order code
   * */
  public function getOrderItemFromCode($code)
  {
    $order_items = $this->entityTypeManager->getStorage('commerce_order_item')->loadByProperties(['field_locators_code' => $code]);

    $order_item = null;
    if(!empty($order_items)){
      $order_item = reset($order_items);
    }

    return $order_item;
  }

  public function getInfoOrderItems($oi_id = null){
    $info = [
      'locators_code' => 0,
      'quantity' => 0,
      'locations' => 0
    ];
    if(isset($oi_id)){
      $order_item = OrderItem::load((int)$oi_id);
      if($order_item->id() > 0){
        $quantity = 0;
        $locators_code = [];
        $locations = [];
        $order_items = $this->getItemsFromOrderItem($order_item);

        foreach($order_items as $oi):
          $quantity += $order_item->getQuantity();
          $locators_code[] = $oi->get('field_locators_code')->value;
          $locations[] = $oi->get('field_location')->value;
        endforeach;

        $info['locators_code'] = implode(', ', $locators_code);
        $info['quantity'] = round($quantity);
        $info['locations'] = implode(', ', $locations);
      }
    }

    return $info;

  }

  private function getItemsFromOrderItem(OrderItemInterface $order_item){
    return $this->entityTypeManager->getStorage('commerce_order_item')->loadByProperties(
      [
        'order_id' => $order_item->get('order_id')->getString(),
        'field_ticket_date' => $order_item->get('field_ticket_date')->getString(),
        'purchased_entity' => $order_item->get('purchased_entity')->getString()
      ]
    );
  }

  public function getPaymentRefernceRedsys(OrderInterface $order){
    $field_reference_redsys = null;
    if($order->get('payment_gateway')->getString() == 'redsys'){
      $request = \Drupal::request();
      $feedback = [
        'Ds_SignatureVersion' => $request->get('Ds_SignatureVersion'),
        'Ds_MerchantParameters' => $request->get('Ds_MerchantParameters'),
        'Ds_Signature' => $request->get('Ds_Signature'),
      ];

      if (!empty($feedback['Ds_SignatureVersion']) && !empty($feedback['Ds_MerchantParameters']) && !empty($feedback['Ds_Signature'])) {
        $payment = $order->get('payment_gateway')->first()->entity;

        // Get the gateway settings.
        $payment_method_settings = $payment->getPluginConfiguration();
        
        // Create a new instance of the Sermepa library and initialize it.
        $gateway = new SermepaApi($payment_method_settings['merchant_name'], $payment_method_settings['merchant_code'], $payment_method_settings['merchant_terminal'], $payment_method_settings['merchant_password'], $payment_method_settings['mode']);

        // Get order number from feedback data and compare it with the order object
        // argument or loaded.
        $parameters = $gateway->decodeMerchantParameters($feedback['Ds_MerchantParameters']);

        $field_reference_redsys = $parameters['Ds_Order'];
      }
    }
    return $field_reference_redsys;
  }

   /**
   * Print order.
   *
   * @return string
   */
  public function create_pdf_order($code, $group = false) {
    if (!$code) {
      throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    }else {
      $order_item = $this->getOrderItemFromCode($code);
      if(!empty($order_item)){
        $order = $order_item->getOrder();

        $user = \Drupal::currentUser();
        $user_roles = $user->getRoles();

        if($order->getState()->value == 'completed' || in_array('administrator', $user_roles)){

            $purchase_entity = $order_item->getPurchasedEntity();
            $rounder_price = \Drupal::service('commerce_price.rounder')->round($order_item->getUnitPrice())->toArray();
            $product = $purchase_entity->getProduct();


            $file_css = 'modules/custom/cact_general/assets/css/ticket.css';
            $css = file_exists($file_css)?file_get_contents($file_css):'';

            $product_info = [];
            if($group && !$order->get('field_reference_openbravo')->isEmpty()){
              $code = $order->get('field_reference_openbravo')->getString();

              foreach ($order->getItems() as $oder_item_ref):
                $purchase_entity_ref = $oder_item_ref->getPurchasedEntity();
                $product_ref = $purchase_entity_ref->getProduct();
                if($product->id() == $product_ref->id()) {
                  $purchase_entity_ref_attributes = $purchase_entity_ref->getAttributeValues();
                  if (is_array($purchase_entity_ref_attributes)) {
                    $purchase_entity_ref_attributes = reset($purchase_entity_ref_attributes);
                  }
                  $rounder_price_order_item_ref = \Drupal::service('commerce_price.rounder')->round($oder_item_ref->getTotalPrice())->toArray();
                  $product_info[] = [
                    'name' => $purchase_entity_ref_attributes->get('name')->getString(),
                    'quantity' => $oder_item_ref->getQuantity(),
                    'seat' => (!$oder_item_ref->get('field_location')->isEmpty()) ? $oder_item_ref->get('field_location')->getString() : null,
                    'price' => $rounder_price_order_item_ref['number'] . ' ' . $rounder_price_order_item_ref['currency_code'],
                  ];
                }
              endforeach;

            }
            $rate = '';
            if ($order->getTotalPrice()->isZero()){
              $rate = 'Gratis';
            }
            else {
              $rate = reset($purchase_entity->getAttributeValues())->get('name')->getString();
            }
            $renderable = [
              '#theme' => 'order_item_pdf',
              '#css' => $css,
              '#logo' => NULL,
              '#code' => $code,
              '#qr_code' => $this->getQrCode($code),
              '#product_name' => $product->getTitle(),
              '#name' => (!$order_item->get('field_name')->isEmpty())?$order_item->get('field_name')->getString():null,
              '#date' => ((int)$product->get('field_event_type')->getString() != 0)?date('d/m/Y H:i', strtotime($order_item->get('field_ticket_date')->getString())):null,
              '#place' => (!$product->get('field_place')->isEmpty())?($product->get('field_place')->getString()):null,
              '#seat' => (!$order_item->get('field_location')->isEmpty())?$order_item->get('field_location')->getString():null,
              '#comments' => (!$order->get('field_comments')->isEmpty())?$order->get('field_comments')->getString():null,
              '#rate' => $rate,
              '#price' => $rounder_price['number'] . ' ' . $rounder_price['currency_code'],
              '#client' => ((int)$product->get('field_event_type')->getString() != 0)?($order->get('field_first_name')->getString() . ' ' . $order->get('field_second_name')->getString()):null,
              '#general_recommendations' => (!$product->get('field_general_recommendations')->isEmpty())?$product->get('field_general_recommendations')->getString():null,
              '#important_information' => (!$product->get('field_important_information')->isEmpty())?$product->get('field_important_information')->getString():null,
              '#group' => $group,
              '#product_info' => $product_info
            ];

            $rendered = \Drupal::service('renderer')->renderPlain($renderable);
            $print_engine = \Drupal::service('plugin.manager.entity_print.print_engine')->createSelectedInstance('pdf');
            $print_engine->addPage($rendered);
            $file = \Drupal::service('file_system')->saveData($print_engine->getBlob(), 'sites/default/files/tmp/order_'.$code.'.pdf');
        }else{
          throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }
      }else{
        throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
      }
    }
  }

  /*
   * Return qr code image
   * */
  public function getQrCode($code){
    $options = new QROptions(
      [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
      ]
    );

    return (new QRCode($options))->render($code);
  }

  public function getPaymentRefernceRedsysShoppingFree(OrderInterface $order){
    $field_reference_redsys = null;
    if($order->get('payment_gateway')->isEmpty()){
      $field_reference_redsys = $order->id();
    }
    return $field_reference_redsys;
  }

}
