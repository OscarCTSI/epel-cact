<?php

namespace Drupal\cact_clone_product\Controller;

use Drupal\commerce_product\Entity\ProductInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\replicate\Replicator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Clone product controller
 */
class CloneProductController extends ControllerBase {
  /**
   * Replicator.
   *
   * @var \Drupal\replicate\Replicator
   */
  protected $replicator;

  /**
   * Constructs the CloneProductController.
   *
   * @param \Drupal\replicate\Replicator $replicator
   *
   */
  public function __construct(Replicator $replicator) {
    $this->replicator = $replicator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('replicate.replicator')
    );
  }

  /*
   * Clone product with variations
   * */
  public function clone(ProductInterface $product){
    $entity_clone = $this->execute($product);
    \Drupal::request()->query->remove('destination');
    $this->messenger()->addMessage(t('the product has been successfully cloned.'));
    return $this->redirect(
      'entity.commerce_product.edit_form',
      ['commerce_product' => $entity_clone->id()],
    );

  }

  /**
   * {@inheritdoc}
   */
  public function execute($entity = NULL) {
    $duplicate_entity = $this->replicator->replicateByEntityId($entity->getEntityTypeId(), $entity->id());
    $title = $duplicate_entity->getTitle();

    $duplicate_entity->setTitle($title . ' - ' . $this->t('Cloned'));
    $request_time = \Drupal::time()->getRequestTime();
    $duplicate_entity->setChangedTime($request_time);

    $variations_ref = [];
    $variations_original_ref = [];
    foreach($duplicate_entity->getVariations() as $variation):
      $duplicate_variation = $this->replicator->replicateByEntityId($variation->getEntityTypeId(), $variation->id());
      $duplicate_variation->set('product_id', $duplicate_entity->id());
      $index = array_search($variation->id(), $duplicate_entity->getVariationIds());
      if ($index !== FALSE) {
        $duplicate_entity->get('variations')->offsetUnset($index);
      }
      $duplicate_variation->save();
      $variations_ref[] = ['target_id' => $duplicate_variation->id()];
      $variations_original_ref[] = ['target_id' => $variation->id()];
    endforeach;

    $entity->setVariations($variations_original_ref);
    $entity->save();

    $duplicate_entity->setVariations($variations_ref);
    $duplicate_entity->save();

    return $duplicate_entity;
  }
}
