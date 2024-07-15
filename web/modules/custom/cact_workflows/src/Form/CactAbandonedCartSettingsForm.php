<?php

namespace Drupal\cact_workflows\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Commerce Abandoned Carts settings form.
 */
class CactAbandonedCartSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cact_workflows_abandoned_carts_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['cact_workflows.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('cact_workflows.settings');

    $form = [];
    $form['number'] = [
      '#type' => 'number',
      '#title' => t('Interval'),
      '#default_value' => ($config->get('number')) ?? 0,
      '#required' => TRUE,
      '#min' => 0,
    ];
    $form['unit'] = [
      '#type' => 'select',
      '#title' => t('Unit'),
      '#title_display' => 'invisible',
      '#default_value' => ($config->get('unit'))??'day',
      '#options' => [
        'minute' => t('Minute'),
        'hour' => t('Hour'),
        'day' => t('Day'),
        'month' => t('Month'),
      ],
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('cact_workflows.settings')
      ->set('number', $form_state->getValue('number'))
      ->set('unit', $form_state->getValue('unit'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
