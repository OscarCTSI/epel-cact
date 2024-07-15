<?php

namespace Drupal\cact_order_item_print\Controller;

use Drupal\cact_general\CactOrderUtility;
use Drupal\cact_order_item_print\AesOrderItem;
use Drupal\commerce_price\RounderInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\entity_print\Plugin\EntityPrintPluginManagerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CommerceOrderPdfController.
 */
class CactOrderItemPdfController extends ControllerBase {
  /**
   * Replicator.
   *
   * @var \Drupal\cact_order_item_print\AesOrderItem
   */
  protected $aesOrderItem;

  /*
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   * */
  protected $moduleHandler;

  /**
   * The rounder.
   *
   * @var \Drupal\commerce_price\RounderInterface
   */
  protected $rounder;

  /**
   * The rounder.
   *
   * @var \Drupal\cact_general\CactOrderUtility
   */
  protected $cactOrderUtility;

  /**
   * The object renderer.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The plugin manager for our Print engines.
   *
   * @var \Drupal\entity_print\Plugin\EntityPrintPluginManagerInterface
   */
  protected $pluginManager;

  /**
   * CactOrderItemPdfController constructor.
   * @param AesOrderItem $aes_order_item
   * @param ModuleHandlerInterface $module_handler
   * @param RounderInterface $rounder
   * @param CactOrderUtility $cact_order_utility
   * @param RendererInterface $renderer
   * @param EntityPrintPluginManagerInterface $plugin_manager
   */
  public function __construct(AesOrderItem $aes_order_item, ModuleHandlerInterface $module_handler, RounderInterface $rounder, CactOrderUtility $cact_order_utility, RendererInterface $renderer, EntityPrintPluginManagerInterface $plugin_manager) {
    $this->aesOrderItem = $aes_order_item;
    $this->moduleHandler = $module_handler;
    $this->rounder = $rounder;
    $this->cactOrderUtility = $cact_order_utility;
    $this->renderer = $renderer;
    $this->pluginManager = $plugin_manager;
  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cact_order_print.aes_order_item'),
      $container->get('module_handler'),
      $container->get('commerce_price.rounder'),
      $container->get('cact_general.order_utility'),
      $container->get('renderer'),
      $container->get('plugin.manager.entity_print.print_engine'),
    );
  }

  /**
   * Print order.
   *
   * @return string
   */
  /*public function print_order($hash_code, $group = false) {
    $code = $this->aesOrderItem->decryptCodeOrderItem($hash_code);

    if (!$code) {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    } else {
        $order_item = $this->cactOrderUtility->getOrderItemFromCode($code);
        if (!empty($order_item)) {
            $order = $order_item->getOrder();

            $user = \Drupal::currentUser();
            $user_roles = $user->getRoles();

            if ($order->getState()->value == 'completed' || in_array('administrator', $user_roles)) {

                $purchase_entity = $order_item->getPurchasedEntity();
                $rounder_price = $this->rounder->round($order_item->getUnitPrice())->toArray();
                $product = $purchase_entity->getProduct();

                $file_css = $this->moduleHandler->getModule('cact_order_item_print')->getPath() . '/assets/css/ticket.css';
                $css = file_exists($file_css) ? file_get_contents($file_css) : '';
                $nominative_names = null;
                $product_info = [];

                if ($group && !$order->get('field_reference_openbravo')->isEmpty()) {
                    $code = $order->get('field_reference_openbravo')->getString();

                    foreach ($order->getItems() as $oder_item_ref) {
                        $purchase_entity_ref = $oder_item_ref->getPurchasedEntity();
                        $product_ref = $purchase_entity_ref->getProduct();
                        if ($product->id() == $product_ref->id()) {
                            $purchase_entity_ref_attributes = $purchase_entity_ref->getAttributeValues();
                            if (is_array($purchase_entity_ref_attributes)) {
                                $purchase_entity_ref_attributes = reset($purchase_entity_ref_attributes);
                            }

                            $rounder_price_order_item_ref = $this->rounder->round($oder_item_ref->getTotalPrice())->toArray();

                            if (!isset($nominative_names)) {
                                $nominative_names = ($oder_item_ref->get('field_name')->isEmpty()) ? null : $oder_item_ref->get('field_name')->getString();
                            } else {
                                $nominative_names .= ($oder_item_ref->get('field_name')->isEmpty()) ? null : ", " . $oder_item_ref->get('field_name')->getString();
                            }

                            $product_info[] = [
                                'name' => $purchase_entity_ref_attributes->get('name')->getString(),
                                'quantity' => $oder_item_ref->getQuantity(),
                                'seat' => ($oder_item_ref->get('field_location')->isEmpty()) ? null : $oder_item_ref->get('field_location')->getString(),
                                'price' => $rounder_price_order_item_ref['number'] . ' ' . $rounder_price_order_item_ref['currency_code'],
                            ];
                        }
                    }
                }

                if (!isset($nominative_names)) {
                    $nominative_names = ($order_item->get('field_name')->isEmpty()) ? null : $order_item->get('field_name')->getString();
                }

                $renderable = [
                    '#theme' => 'order_item_pdf',
                    '#css' => $css,
                    '#logo' => NULL,
                    '#code' => $code,
                    '#qr_code' => $this->aesOrderItem->getQrCode($code),
                    '#product_name' => $product->getTitle(),
                    '#name' => $nominative_names,
                    '#date' => ((int)$product->get('field_event_type')->getString() != 0) ? date('d/m/Y H:i', strtotime((string)$order_item->get('field_ticket_date')->getString())) : null,
                    '#place' => ($product->get('field_place')->isEmpty()) ? null : $product->get('field_place')->getString(),
                    '#seat' => ($order_item->get('field_location')->isEmpty()) ? null : $order_item->get('field_location')->getString(),
                    '#comments' => ($order->get('field_comments')->isEmpty()) ? null : $order->get('field_comments')->getString(),
                    '#rate' => reset($purchase_entity->getAttributeValues())->get('name')->getString(),
                    '#price' => $rounder_price['number'] . ' ' . $rounder_price['currency_code'],
                    '#client' => ((int)$product->get('field_event_type')->getString() != 0) ? ($order->get('field_first_name')->getString() . ' ' . $order->get('field_second_name')->getString()) : null,
                    '#general_recommendations' => ($product->get('field_general_recommendations')->isEmpty()) ? null : $product->get('field_general_recommendations')->getString(),
                    '#important_information' => ($product->get('field_important_information')->isEmpty()) ? null : $product->get('field_important_information')->getString(),
                    '#group' => $group,
                    '#product_info' => $product_info
                ];

                $rendered = $this->renderer->render($renderable);

                $print_engine = $this->pluginManager->createSelectedInstance('pdf');

                $print_engine->addPage($rendered);

                return (new StreamedResponse(function () use ($print_engine, $code) {
                    $print_engine->send($code . '.pdf');
                }));
            } else {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
            }
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        }
    }
}*/
public function print_order($hash_code, $group = false) {
    $code = $this->aesOrderItem->decryptCodeOrderItem($hash_code);

    if (!$code) {
        throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    } else {
        $order_item = $this->cactOrderUtility->getOrderItemFromCode($code);
        if (!empty($order_item)) {
            $order = $order_item->getOrder();

            $user = \Drupal::currentUser();
            $user_roles = $user->getRoles();

            if ($order->getState()->value == 'completed' || in_array('administrator', $user_roles)) {

                $purchase_entity = $order_item->getPurchasedEntity();
                $rounder_price = $this->rounder->round($order_item->getUnitPrice())->toArray();
                $product = $purchase_entity->getProduct();

                $file_css = $this->moduleHandler->getModule('cact_order_item_print')->getPath() . '/assets/css/ticket.css';
                $css = file_exists($file_css) ? file_get_contents($file_css) : '';
                $nominative_names = null;
                $product_info = [];

                if ($group && !$order->get('field_reference_openbravo')->isEmpty()) {
                    $code = $order->get('field_reference_openbravo')->getString();

                    foreach ($order->getItems() as $oder_item_ref) {
                        $purchase_entity_ref = $oder_item_ref->getPurchasedEntity();
                        $product_ref = $purchase_entity_ref->getProduct();
                        if ($product->id() == $product_ref->id()) {
                            $purchase_entity_ref_attributes = $purchase_entity_ref->getAttributeValues();
                            if (is_array($purchase_entity_ref_attributes)) {
                                $purchase_entity_ref_attributes = reset($purchase_entity_ref_attributes);
                            }

                            $rounder_price_order_item_ref = $this->rounder->round($oder_item_ref->getTotalPrice())->toArray();

                            if (!isset($nominative_names)) {
                                $nominative_names = ($oder_item_ref->get('field_name')->isEmpty()) ? null : $oder_item_ref->get('field_name')->getString();
                            } else {
                                $nominative_names .= ($oder_item_ref->get('field_name')->isEmpty()) ? null : ", " . $oder_item_ref->get('field_name')->getString();
                            }

                            $product_info[] = [
                                'name' => $purchase_entity_ref_attributes->get('name')->getString(),
                                'quantity' => $oder_item_ref->getQuantity(),
                                'seat' => ($oder_item_ref->get('field_location')->isEmpty()) ? null : $oder_item_ref->get('field_location')->getString(),
                                'price' => $rounder_price_order_item_ref['number'] . ' ' . $rounder_price_order_item_ref['currency_code'],
                            ];
                        }
                    }
                }

                if (!isset($nominative_names)) {
                    $nominative_names = ($order_item->get('field_name')->isEmpty()) ? null : $order_item->get('field_name')->getString();
                }

                $attributes = $purchase_entity->getAttributeValues();
                $first_attribute = reset($attributes);

                $renderable = [
                    '#theme' => 'order_item_pdf',
                    '#css' => $css,
                    '#logo' => NULL,
                    '#code' => $code,
                    '#qr_code' => $this->aesOrderItem->getQrCode($code),
                    '#product_name' => $product->getTitle(),
                    '#name' => $nominative_names,
                    '#date' => ((int)$product->get('field_event_type')->getString() != 0) ? date('d/m/Y H:i', strtotime((string)$order_item->get('field_ticket_date')->getString())) : null,
                    '#place' => ($product->get('field_place')->isEmpty()) ? null : $product->get('field_place')->getString(),
                    '#seat' => ($order_item->get('field_location')->isEmpty()) ? null : $order_item->get('field_location')->getString(),
                    '#comments' => ($order->get('field_comments')->isEmpty()) ? null : $order->get('field_comments')->getString(),
                    '#rate' => $first_attribute->get('name')->getString(),
                    '#price' => $rounder_price['number'] . ' ' . $rounder_price['currency_code'],
                    '#client' => ((int)$product->get('field_event_type')->getString() != 0) ? ($order->get('field_first_name')->getString() . ' ' . $order->get('field_second_name')->getString()) : null,
                    '#general_recommendations' => ($product->get('field_general_recommendations')->isEmpty()) ? null : $product->get('field_general_recommendations')->getString(),
                    '#important_information' => ($product->get('field_important_information')->isEmpty()) ? null : $product->get('field_important_information')->getString(),
                    '#group' => $group,
                    '#product_info' => $product_info
                ];

                $rendered = $this->renderer->render($renderable);

                $print_engine = $this->pluginManager->createSelectedInstance('pdf');

                $print_engine->addPage($rendered);

                return (new StreamedResponse(function () use ($print_engine, $code) {
                    $print_engine->send($code . '.pdf');
                }));
            } else {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
            }
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
        }
    }
}


}
