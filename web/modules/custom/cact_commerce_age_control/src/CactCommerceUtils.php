<?php

namespace Drupal\cact_commerce_age_control;

use Drupal\commerce\PurchasableEntityInterface;
use Drupal\commerce_cart\CartProviderInterface;
use Drupal\commerce_order\AvailabilityManagerInterface;
use Drupal\commerce_store\CurrentStoreInterface;
use Drupal\commerce_store\Entity\StoreInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Class CactCommerceUtils
 *
 * @package Drupal\cact_commerce_age_control
 */
class CactCommerceUtils
{
  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * The availability manager.
   *
   * @var \Drupal\commerce\AvailabilityManagerInterface
   */
  protected $availabilityManager;

  /**
   * The current store.
   *
   * @var \Drupal\commerce_store\CurrentStoreInterface
   */
  protected $currentStore;

  /**
   * The cart provider.
   *
   * @var \Drupal\commerce_cart\CartProviderInterface
   */
  protected $cartProvider;

  /**
   * CactCommerceUtils constructor.
   * @param AccountInterface $account
   * @param AvailabilityManagerInterface $availability_manager
   * @param CurrentStoreInterface $current_store
   * @param CartProviderInterface $cart_provider
   */
  public function __construct(AccountInterface $account, AvailabilityManagerInterface $availability_manager, CurrentStoreInterface $current_store, CartProviderInterface $cart_provider)
  {
    $this->account = $account;
    $this->availabilityManager = $availability_manager;
    $this->currentStore = $current_store;
    $this->cartProvider = $cart_provider;
  }


  private function selectStore(PurchasableEntityInterface $entity): StoreInterface
  {
    $stores = $entity->getStores();
    if (count($stores) === 1) {
      $store = reset($stores);
    }
    elseif (count($stores) === 0) {
      throw new \Exception('The given entity is not assigned to any store.');
    }
    else {
      $store = $this->currentStore->getStore();
      if (!in_array($store, $stores)) {
        throw new \Exception("The given entity can't be purchased from the current store.");
      }
    }

    return $store;
  }

  public function getCart(PurchasableEntityInterface $entity, $create = true){
    $store = $this->selectStore($entity);
    $cart = $this->cartProvider->getCart('default', $store, $this->account);
    if (!$cart && $create) {
      $cart = $this->cartProvider->createCart('default', $store, $this->account);
    }
    return $cart;
  }

  public function getCartNumberPurchaseEntity(PurchasableEntityInterface $entity, $session_id){
    $cart = $this->getCart($entity, false);
    $quantity_puchase = 0;
    if($cart && !empty($cart->hasItems())){
      foreach($cart->getItems() as $index_cart => $order_item):
        if($order_item->getPurchasedEntity()->id() == $entity->id() &&
          (!isset($session_id) || $session_id == $order_item->get('field_session')->getString())){
          $quantity_puchase += $order_item->getQuantity();
        }
      endforeach;
    }
    return (int)$quantity_puchase;
  }
  
}
