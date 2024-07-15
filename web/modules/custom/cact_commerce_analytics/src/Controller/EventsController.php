<?php

namespace Drupal\cact_commerce_analytics\Controller;

use Drupal\commerce_google_tag_manager\EventTrackerService;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * A controller to receive the tracked Enhanced Ecommerce events.
 *
 * Called via ajax on a page load to actually send the tracked events
 * (server-side) to Google Tag Manager.
 */
class EventsController extends ControllerBase {

  /**
   * The Commerce GTM event tracker.
   *
   * @var \Drupal\commerce_google_tag_manager\EventTrackerService
   */
  private $eventTracker;

  /**
   * The Drupal Entity Type Manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  private $entityManager;


  /**
   * The Drupal Entity Repository.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  private $entityRepository;

  /**
   * Constructs the EventsController object.
   *
   * @param \Drupal\commerce_google_tag_manager\EventTrackerService $event_tracker
   *   The Commerce GTM event tracker.
   * @param \Drupal\Core\Entity\EntityTypeManager $entity_manager
   */
  public function __construct(EventTrackerService $event_tracker, EntityTypeManager $entity_manager, EntityRepositoryInterface $entity_repository) {
    $this->eventTracker = $event_tracker;
    $this->entityManager = $entity_manager;
    $this->entityRepository = $entity_repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('commerce_google_tag_manager.event_tracker'),
      $container->get('entity_type.manager'),
      $container->get('entity.repository'));
  }

  /**
   * Track a "product click" event.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The event format as JSON.
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function trackProductClickEvent(Request $request) {
    $language =  \Drupal::languageManager()->getCurrentLanguage()->getId();
    // Search variation if request have variation parameter
    if ($variationId = $request->get("variation")){
      $variation = $this->entityManager
        ->getStorage('commerce_product_variation')->load($variationId);
      $variation = $this->entityRepository->getTranslationFromContext($variation, $language);
      // Else search variation if request have product parameter
    }elseif ($productId = $request->get("product")){
      $product = $this->entityManager
        ->getStorage('commerce_product')->load($productId);
      if ($product) {
        $variation = $product->getDefaultVariation();
        $variation = $this->entityRepository->getTranslationFromContext($variation, $language);
      }
    }else{
      return new JsonResponse(FALSE, Response::HTTP_BAD_REQUEST);
    }

    if (isset($variation)) {
      // Track click event
      $this->eventTracker->productClick([$variation]);
      return new JsonResponse(TRUE);
    }else {
      return new JsonResponse(FALSE, Response::HTTP_NOT_FOUND);
    }
  }

}
