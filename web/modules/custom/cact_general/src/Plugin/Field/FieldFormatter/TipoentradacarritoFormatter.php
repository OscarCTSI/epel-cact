<?php

namespace Drupal\cact_general\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'TipoEntradaCarrito' formatter.
 *
 * @FieldFormatter(
 *   id = "cact_general_tipoentradacarrito",
 *   label = @Translation("TipoEntradaCarrito"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class TipoentradacarritoFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    foreach ($items as $delta => $item) {
      $value = explode('-', $item->value);
      if (count($value) == 2){
        $html = '<div class="type_ticket_cart">' . $value[1] . '</div><div class="title_ticket_cart">' . $value[0] . '</div>';
        $element[$delta] = [
          '#markup' => $html,
        ];
      }
      else{
        $element[$delta] = [
          '#markup' => $item->value,
        ];
      }

    }

    return $element;
  }

}
