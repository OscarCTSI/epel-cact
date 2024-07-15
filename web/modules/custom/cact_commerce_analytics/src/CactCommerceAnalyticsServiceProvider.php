<?php

namespace Drupal\cact_commerce_analytics;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use Symfony\Component\DependencyInjection\Reference;

class CactCommerceAnalyticsServiceProvider extends ServiceProviderBase implements ServiceProviderInterface {

  public function alter(ContainerBuilder $container) {
    if ($container->hasDefinition('commerce_google_tag_manager.event_tracker')) {
      //Overrride EventTrackerService
      $container->getDefinition('commerce_google_tag_manager.event_tracker')
        ->setClass(CactEventTrackerService::class)
        ->setArguments([
          new Reference('commerce_google_tag_manager.event_storage'),
          new Reference('event_dispatcher'),
          new Reference('commerce_store.current_store'),
          new Reference('current_user'),
          new Reference('commerce_order.price_calculator'),
        ]);
    }
  }

}
