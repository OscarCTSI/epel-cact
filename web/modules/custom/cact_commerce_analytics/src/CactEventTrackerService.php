<?php

namespace Drupal\cact_commerce_analytics;

use Drupal\commerce\Context;
use Drupal\commerce_google_tag_manager\Event\AlterProductEvent;
use Drupal\commerce_google_tag_manager\Event\EnhancedEcommerceEvents;
use Drupal\commerce_google_tag_manager\EventStorageService;
use Drupal\commerce_google_tag_manager\EventTrackerService;
use Drupal\commerce_google_tag_manager\Product;
use Drupal\commerce_order\PriceCalculatorInterface;
use Drupal\commerce_product\Entity\ProductVariationInterface;
use Drupal\commerce_store\CurrentStoreInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Override EventTrackerService class
 * Track different events from Google's Enhanced Ecommerce.
 *
 * @see https://developers.google.com/tag-manager/enhanced-ecommerce
 */
class CactEventTrackerService extends EventTrackerService {

  /**
   * The Commerce GTM event storage.
   *
   * @var \Drupal\commerce_google_tag_manager\EventStorageService
   */
  private $eventStorage;

  /**
   * Constructs the EventTrackerService service.
   *
   * @param \Drupal\commerce_google_tag_manager\EventStorageService $event_storage
   *   The Commerce GTM event storage.
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
   *   The event dispatcher.
   * @param \Drupal\commerce_store\CurrentStoreInterface $current_store
   *   The current store.
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   The current user.
   * @param \Drupal\commerce_order\PriceCalculatorInterface $price_calculator
   *   The price calculator.
   */
  public function __construct(EventStorageService $event_storage,
                              /**
                               * The event dispatcher.
                               */
                              private readonly EventDispatcherInterface $eventDispatcher,
                              CurrentStoreInterface $current_store,
                              /**
                               * The current user.
                               */
                              private readonly AccountInterface $currentUser,
                              PriceCalculatorInterface $price_calculator) {
    $this->eventStorage = $event_storage;
    parent::__construct($event_storage, $this->eventDispatcher, $current_store, $this->currentUser, $price_calculator);
  }

  /**
   * Track product impressions.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface[] $product_variations
   *   The commerce product variation entities being viewed.
   * @param string $list
   *   The name of the list showing the products.
   */
  public function productImpressions(array $product_variations, $list = '') {
    $products_data = array_map(function ($product_variation) use ($list) {
      return array_merge(
        $this->buildProductFromProductVariation($product_variation)->toArray(),
        ['list' => $list]);
    }, $product_variations);

    $data = [
      'event' => self::EVENT_PRODUCT_IMPRESSIONS,
      'ecommerce' => [
        'impressions' => $products_data,
      ],
    ];

    $this->eventStorage->addEvent($data);
  }

  /**
   * Track product detail views.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariation[] $product_variations
   *   The commerce product variations being viewed.
   * @param string $list
   *   An optional name of a list.
   */
  public function productDetailViews(array $product_variations, $list = '') {
    $data = [
      'event' => self::EVENT_PRODUCT_DETAIL_VIEWS,
      'ecommerce' => [
        'detail' => [
          'actionField' => ['list' => $list],
          'products' => $this->buildProductsFromProductVariations($product_variations),
        ],
      ],
    ];

    $this->eventStorage->addEvent($data);
  }

  /**
   * Build Enhanced Ecommerce product from a given commerce product variation.
   *
   * @param \Drupal\commerce_product\Entity\ProductVariationInterface $product_variation
   *   A commerce product variation.
   *
   * @return \Drupal\commerce_google_tag_manager\Product
   *   The Enhanced Ecommerce product.
   */
  private function buildProductFromProductVariation(ProductVariationInterface $product_variation) {
    $context = new Context($this->currentUser, $this->currentStore->getStore());

    $product = new Product();
    $product
      ->setName($product_variation->getProduct()->getTitle())
      ->setId($product_variation->getProduct()->id())
      ->setVariant($product_variation->getTitle());

    // Get price based on resolver(s).
    /** @var \Drupal\commerce_price\Price $calculated_price */
    $calculated_price = $this->priceCalculator->calculate($product_variation, 1, $context)
      ->getCalculatedPrice();
    if ($calculated_price) {
      $product->setPrice(self::formatPrice((float) $calculated_price->getNumber()));
    }

    $event = new AlterProductEvent($product, $product_variation);
    $this->eventDispatcher->dispatch(EnhancedEcommerceEvents::ALTER_PRODUCT, $event);

    return $product;
  }

  /**
   * Build Enhanced Ecommerce products from given commerce product variations.
   *
   * @param array $product_variations
   *   The commerce product variations.
   *
   * @return array
   *   An array of EnhancedEcommerce products.
   */
  private function buildProductsFromProductVariations(array $product_variations) {
    return array_map(function ($product_variation) {
      return $this
        ->buildProductFromProductVariation($product_variation)
        ->toArray();
    }, $product_variations);
  }

}
