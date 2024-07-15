<?php

namespace Drupal\cact_workflows\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\commerce_order\Event\OrderEvent;
use Drupal\state_machine\Event\WorkflowTransitionEvent;

/**
 * Responds to cartEntityAddEvent to add add-on's to an order.
 */
class CactPaymentOrderEventSubscriber implements EventSubscriberInterface {


  public static function getSubscribedEvents() {
    // The format for adding a state machine event to subscribe to is:
    // {group}.{transition key}.pre_transition or {group}.{transition key}.post_transition
    // depending on when you want to react.
    $events = [
      'commerce_order.order.paid' => ['onOrderPaid', 100],
      'commerce_order.place.pre_transition' => ['onPlacePreTransition', 100]
    ];
    return $events;
  }

  public function onOrderPaid(OrderEvent $event) {
    // get the current order
    $order = $event->getOrder();
    //if payment state is completed
    // apply transition to order
    if($order->isPaid() && ($order->getState()->getId() != 'completed' && $order->getState()->getId() == 'pending')) {
      $order->getState()->applyTransitionById('process');
    }
  }
  public function onPlacePreTransition(WorkflowTransitionEvent $event) {
    $order = $event->getEntity();
    if($order->getState()->getId() != 'pending' && $order->getState()->getId() == 'draft') {
      $order->getState()->applyTransitionById('place');
    }
    // apply transition to order
    if($order->isPaid() && ($order->getState()->getId() != 'completed' && $order->getState()->getId() == 'pending')) {
      $order->getState()->applyTransitionById('process');
    }
  }
}
