<?php

namespace Drupal\cact_openbravo\EventSubscriber;

use Drupal\cact_general\CactOrderUtility;
use Drupal\cact_openbravo\CactOpenbravoEntityHandler;
use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_cart\Event\CartEvents;
use Drupal\commerce_cart\Event\CartOrderItemRemoveEvent;
use Drupal\commerce_cart\Event\CartOrderItemUpdateEvent;
use Drupal\commerce_order\Mail\OrderReceiptMailInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Responds to cartEntityAddEvent to add add-on's to an order.
 */
class CactOpenbravoEventSubscriber implements EventSubscriberInterface {
  /**
   * Integration with entity and openbravo.
   *
   * @var \Drupal\cact_openbravo\CactOpenbravoEntityHandler
   */
  protected $cactOpenbravoEntityHandler;
  /**
   *
   * @var \Drupal\cact_openbravo\CactOpenbravoServices
   */
  protected $cactOpenbravoServices;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The order receipt mail.
   *
   * @var \Drupal\commerce_order\Mail\OrderReceiptMailInterface
   */
  protected $orderReceiptMail;

  /**
   * CactOpenbravoEventSubscriber constructor.
   * @param MessengerInterface $messenger
   * @param CactOpenbravoEntityHandler $cact_openbravo_entity_handler
   * @param CactOrderUtility $cactOrderUtility
   * @param EntityTypeManagerInterface $entity_type_manager
   * @param OrderReceiptMailInterface $order_receipt_mail
   */
  public function __construct(private readonly MessengerInterface $messenger, CactOpenbravoEntityHandler $cact_openbravo_entity_handler, private readonly CactOrderUtility $cactOrderUtility, EntityTypeManagerInterface $entity_type_manager, OrderReceiptMailInterface $order_receipt_mail) {
    $this->cactOpenbravoEntityHandler = $cact_openbravo_entity_handler;
    $this->entityTypeManager = $entity_type_manager;
    $this->orderReceiptMail = $order_receipt_mail;
  }
  /**
   * Get subscribed events.
   *
   * @return array
   *   The subscribed events.
   */
  public static function getSubscribedEvents() {
    return [
      CartEvents::CART_ENTITY_ADD => ['cartEntityAddEvent', 100],
      CartEvents::CART_ORDER_ITEM_REMOVE => ['cartEntityRemoveEvent', 100],
      CartEvents::CART_ORDER_ITEM_UPDATE => ['cartEntityUpdateEvent', 100],
      'commerce_order.process.pre_transition' => ['preTransition', -200],
      'commerce_order.process.post_transition' => ['postTransition', -200],
      'commerce_order.leave.post_transition' => ['onLeaveProTransition', -200]
    ];
  }

  /**
   * Call createPrereserve: Create
   * Drupal\cact_openbravo\CactOpenBravoEntityHandler method setPrereserve()
   *
   */
  public function cartEntityAddEvent(CartEntityAddEvent $event) {
    if(!$this->cactOpenbravoEntityHandler->setPrereserve($event->getOrderItem())){
      $this->messenger->addError('An error occurred while making the reservation.');
    }
  }

  /**
   * Call createPrereserve: Remove
   * Drupal\cact_openbravo\CactOpenBravoEntityHandler method removePrereserve()
   */
  public function cartEntityRemoveEvent(CartOrderItemRemoveEvent $event) {
    $this->cactOpenbravoEntityHandler->removePrereserve($event->getOrderItem());
  }

  /**
   * Call createPrereserve: Update
   * Drupal\cact_openbravo\CactOpenBravoEntityHandler method createPrereserve()
   *
   */
  public function cartEntityUpdateEvent(CartOrderItemUpdateEvent $event) {

  }

  /*
   * Set locators code to order items   *
   * Call order
   * Drupal\cact_openbravo\CactOpenBravoEntityHandler method order()
   *
   * */
  public function postTransition(WorkflowTransitionEvent $event){
    $this->finalizeCart($event->getEntity());
  }

  public function preTransition(WorkflowTransitionEvent $event){
    \Drupal::logger('cact_openbravo')->notice('preTransition' . $event->getEntity()->getState()->getId());
  }

  private function finalizeCart($order){
    $this->cactOrderUtility->setLocatorsCode($order);

    $response = $this->cactOpenbravoEntityHandler->setOrder($order);
    if(!$response){
      $order->getState()->applyTransitionById('problem');
    }else{
      $order_type_storage = $this->entityTypeManager->getStorage('commerce_order_type');
      /** @var \Drupal\commerce_order\Entity\OrderTypeInterface $order_type */
      $order_type = $order_type_storage->load($order->bundle());
      if (!$order_type->shouldSendReceipt()) {
        $this->orderReceiptMail->send($order, $order->getEmail(), $order_type->getReceiptBcc());
      }
    }
  }

  /*
    * Abandonated carts
    * Drupal\cact_openbravo\CactOpenBravoEntityHandler method removePrereserve()
    *
    * */
  public function onLeaveProTransition(WorkflowTransitionEvent $event){
    $order = $event->getEntity();
    foreach($order->getItems() as $order_item):
      $this->cactOpenbravoEntityHandler->removePrereserve($order_item);
    endforeach;
  }
}
