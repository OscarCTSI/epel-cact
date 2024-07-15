<?php

namespace Drupal\cact_general\TwigExtension;

use Drupal\commerce_order\Entity\OrderItem;
use Drupal\commerce_order\Entity\OrderItemInterface;
use Drupal\commerce_product\Entity\ProductVariation;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * OrderItemInfo functions.
 */
class OrderItemInfo extends AbstractExtension {
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * OrderItemInfo constructor.
   * @param EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager)
  {
    $this->entityTypeManager = $entity_type_manager;
  }

  public function getFilters() {
    return [
      new TwigFilter('get_locations', [$this, 'getLocations']),
      new TwigFilter('get_locators', [$this, 'getLocators']),
      new TwigFilter('print_date', [$this, 'printDate']),
    ];
  }

  public function getLocations($oi_id) {
    $order_item = OrderItem::load((int)$oi_id);
    $locations = [];
    if(isset($order_item) && $order_item->id() > 0){
      $order_items = $this->getItemsFromOrderItem($order_item);

      foreach($order_items as $oi):
        if(!$oi->get('field_location')->isEmpty()){
            $locations[] = $oi->get('field_location')->getString();
        }
      endforeach;
    }

    return implode(', ', $locations);
  }

  public function getLocators($oi_id) {
    $order_item = OrderItem::load((int)$oi_id);
    $locators_code = [];
    if(isset($order_item) && $order_item->id() > 0){
      $order_items = $this->getItemsFromOrderItem($order_item);

      foreach($order_items as $oi):
        if(!$oi->get('field_locators_code')->isEmpty()){
          foreach($oi->get('field_locators_code')->getValue() as $lc):
            $locators_code[] = $lc['value'];
          endforeach;
        }
      endforeach;
    }

    return implode(', ', $locators_code);
  }

  private function getItemsFromOrderItem(OrderItemInterface $order_item){
    return $this->entityTypeManager->getStorage('commerce_order_item')->loadByProperties(
      [
        'order_id' => $order_item->get('order_id')->getString(),
        'field_ticket_date' => ($order_item->hasField('field_ticket_date'))?$order_item->get('field_ticket_date')->getString():'-',
        'purchased_entity' => $order_item->get('purchased_entity')->getString()
      ]
    );
  }

  public function printDate($pe_id) {
    $product_variation = ProductVariation::load((int)$pe_id->jsonSerialize());
    $commerce_product = $product_variation->getProduct();
    $print_date = true;
    if($commerce_product->id() > 0 && $commerce_product->get('field_event_type')->value == 0){
      $print_date = false;
    }

    return $print_date;
  }
}
