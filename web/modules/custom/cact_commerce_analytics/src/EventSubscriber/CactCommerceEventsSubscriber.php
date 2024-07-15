<?php

namespace Drupal\cact_commerce_analytics\EventSubscriber;

use Drupal\commerce_cart\Event\CartEntityAddEvent;
use Drupal\commerce_cart\Event\CartEvents;
use Drupal\commerce_cart\Event\CartOrderItemRemoveEvent;
use Drupal\commerce_google_tag_manager\EventTrackerService;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\state_machine\Event\WorkflowTransitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Event handler for commerce related events.
 */
class CactCommerceEventsSubscriber implements EventSubscriberInterface {

  /**
   * The Commerce GTM event tracker.
   *
   * @var \Drupal\commerce_google_tag_manager\EventTrackerService
   */
  private $eventTracker;

  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Constructs the CommerceEventsSubscriber object.
   *
   * @param \Drupal\commerce_google_tag_manager\EventTrackerService $event_tracker
   *   The Commerce GTM event tracker.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match, for context.
   */
  public function __construct(EventTrackerService $event_tracker, RouteMatchInterface $route_match) {
    $this->eventTracker = $event_tracker;
    $this->routeMatch = $route_match;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      // trackProductView should run before Dynamic Page Cache, which has priority 27
      // see Drupal\dynamic_page_cache\EventSubscriber\DynamicPageCacheSubscriber
      KernelEvents::REQUEST => ['trackProductView', 30]
    ];
  }

  /**
   * Track the "productView" event.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The event to view the product.
   */
  public function trackProductView(GetResponseEvent $event) {
    $product = $this->routeMatch->getParameter('commerce_product');
    if ($event->getRequest()->getMethod() === 'GET' && !empty($product) && $this->routeMatch->getRouteName() === 'entity.commerce_product.canonical') {
      $default_variation = $product->getDefaultVariation();

      if ($default_variation) {
        $this->eventTracker->productImpressions([$default_variation], 'Search Results');
      }
    }
  }

}
