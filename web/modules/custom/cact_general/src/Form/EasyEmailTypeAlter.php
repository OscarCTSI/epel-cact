<?php

namespace Drupal\cact_general\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\easy_email\Form\EasyEmailTypeForm;
use Drupal\easy_email\Entity\EasyEmailType;

/**
 * Supplement form UI to add setting for which blocks & layouts are available.
 */
class EasyEmailTypeAlter extends EasyEmailTypeForm {

  /**
   * The actual form elements.
   */
  public function alterForm(&$form, FormStateInterface $form_state, $form_id) {
    $attribute = $form_state->getFormObject()->getEntity();
    $message_product_pay = $attribute->getThirdPartySetting('cact_general', 'message_product_pay');
    $message_product_free = $attribute->getThirdPartySetting('cact_general', 'message_product_free');
    $form['body_html']['message_product_pay'] = [
        '#type' => 'text_format',
        '#rows' => 30,
        '#title' => $this->t('Message product (pay) available token : [cact:message_product_pay]'),
        '#default_value' => !empty($message_product_pay) ? $message_product_pay['value'] : NULL,
        '#format' => !empty($message_product_pay) ? $message_product_pay['format'] : NULL,
    ];
    $form['body_html']['message_product_free'] = [
        '#type' => 'text_format',
        '#rows' => 30,
        '#title' => $this->t('Message product (free) available token [cact:message_product_free]'),
        '#default_value' => !empty($message_product_free) ? $message_product_free['value'] : NULL,
        '#format' => !empty($message_product_free) ? $message_product_free['format'] : NULL,
    ];
    $form['actions']['submit']['#submit'][]  = [$this, 'alterSubmit'];
   
  }

  /**
   * Extend submit callback.
   */
  public function alterSubmit(&$form, FormStateInterface $form_state) {
    $attribute = $form_state->getFormObject()->getEntity();
    if ( $attribute && $form_state->getValue('message_product_pay')) {
      $attribute->setThirdPartySetting('cact_general', 'message_product_pay', $form_state->getValue('message_product_pay'));
      $attribute->setThirdPartySetting('cact_general', 'message_product_free', $form_state->getValue('message_product_free'));
      $attribute->save();
      $this->messenger->addMessage($this->t('Saved Message product (free), Message product (pay).  the %label Email type.', [
        '%label' => $attribute->label(),
      ]));
      return;
    }
  }

}
