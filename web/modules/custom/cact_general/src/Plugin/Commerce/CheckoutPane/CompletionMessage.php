<?php

namespace Drupal\cact_general\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CompletionMessage as BaseCompletionMessage;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a custom payment information pane.
 */
class CompletionMessage extends BaseCompletionMessage {

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    $pane_form = parent::buildPaneForm($pane_form, $form_state, $complete_form);
    // Do something custom with the pane form here.
    if ($this->order->getTotalPrice()->isZero() && $this->order->get('checkout_step')->value == 'complete') {
       unset($pane_form['message']);
    }  
    return $pane_form;
  }

}