<?php

namespace Drupal\cact_order_item_print\Plugin\EntityPrint\PrintEngine;

use Drupal\entity_print\Plugin\EntityPrint\PrintEngine\DomPdf;


/**
 * A CACT plugin for the DomPdf library.
 *
 * @PrintEngine(
 *   id = "cact_dompdf",
 *   label = @Translation("CACT Dompdf"),
 *   export_type = "pdf"
 * )
 */
class CactDomPdf extends DomPdf {

  public function setPaper($size, $orientation = "portrait"){
    $this->dompdf->setPaper($size, $orientation);
  }
}
