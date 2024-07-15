<?php

namespace Drupal\cact_openbravo\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a form that configures forms module settings.
 */
class CactOpenbravoConfigurationForm extends ConfigFormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * CactOrderUtility constructor.
   * @param EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager)
  {
    $this->entityTypeManager = $entity_type_manager;
  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'cact_openbravo_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'cact_openbravo.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('cact_openbravo.settings');
    $form["#attributes"]["autocomplete"] = "off";
    $form['cact_openbravo'] = array(
      '#type'  => 'fieldset',
      '#title' => $this->t('Cact Openbravo API settings'),
      '#required' => TRUE,
    );
    $form['cact_openbravo']['url'] = array(
      '#type'          => 'textfield',
      '#title'         => $this->t('Cact Openbravo API URL'),
      '#default_value' => $config->get('cact_openbravo.url'),
      '#required' => TRUE,
    );
    $form['cact_openbravo']['user'] = array(
      '#type'          => 'textfield',
      '#title'         => $this->t('Cact Openbravo User'),
      '#default_value' => $config->get('cact_openbravo.user'),
    );
    $form['cact_openbravo']['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Cact Openbravo Password'),
      '#default_value' => $config->get('cact_openbravo.password')
    ];

    $form['cact_openbravo']['mails'] = [
      '#type'           => 'textfield',
      '#title'          => $this->t('Mails separate by comma.'),
      '#description'    => $this->t('If there is an error in openbravo, an email is sent to the emails in the field.'),
      '#default_value'  => $config->get('cact_openbravo.mails')
    ];

    $payments_gateways = $config->get('cact_openbravo.payments_gateways');
    $payment_gateway_storage = $this->entityTypeManager->getStorage('commerce_payment_gateway');
    $payments_gateways_storage = $payment_gateway_storage->loadMultiple();


    $form['cact_openbravo']['payments_gateways'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Payments gateways'),
    ];
    foreach($payments_gateways_storage as $index => $payment_gateway):
      $form['cact_openbravo']['payments_gateways'][$index] = [
        '#type' => 'textfield',
        '#title' => $payment_gateway->label(),
        '#default_value' => ($payments_gateways[$index])??'',
        '#required' => TRUE,
      ];
    endforeach;

    $form['cact_openbravo']['no_integration'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('No integration'),
      '#default_value' => $config->get('cact_openbravo.no_integration'),
    ];

    $sandbox = $config->get('cact_openbravo.sandbox');
    $form['cact_openbravo']['sandbox_enable'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Sandbox'),
      '#default_value' => !empty($sandbox['sandbox_enable']),
    ];
    $form['cact_openbravo']['customer'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['customer'],
      ],
      '#states' => [
        'visible' => [
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ],
      ],
      '#open' => TRUE,
    ];

    $form['cact_openbravo']['customer']['customer_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => ($sandbox['customer_name'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];

    $form['cact_openbravo']['customer']['customer_fiscal_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Fiscal name'),
      '#default_value' => ($sandbox['customer_fiscal_name'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];

    $form['cact_openbravo']['customer']['customer_tax_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Tax id'),
      '#default_value' => ($sandbox['customer_tax_id'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];

    $form['cact_openbravo']['customer']['customer_address_line1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address line 1'),
      '#default_value' => ($sandbox['customer_address_line1'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];

    $form['cact_openbravo']['customer']['customer_address_line2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Address line 2'),
      '#default_value' => ($sandbox['customer_address_line2'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];
    $form['cact_openbravo']['customer']['customer_postal_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Postal code'),
      '#default_value' => ($sandbox['customer_postal_code'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];
    $form['cact_openbravo']['customer']['customer_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => ($sandbox['customer_city'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];
    $form['cact_openbravo']['customer']['customer_region_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Region code'),
      '#default_value' => ($sandbox['customer_region_code'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];
    $form['cact_openbravo']['customer']['customer_country_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country code'),
      '#default_value' => ($sandbox['customer_country_code'])??'',
      '#states' => [
        'required' => array(
          ':input[name="sandbox_enable"]' => ['checked' => TRUE],
        ),
      ]
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $config = $this->config('cact_openbravo.settings');
    $config->set('cact_openbravo.url', $values['url']);
    $config->set('cact_openbravo.user', $values['user']);
    if(!empty($values['password'])){
      $config->set('cact_openbravo.password', $values['password']);
    }
    $config->set('cact_openbravo.mails', $values['mails']);

    $config->set('cact_openbravo.no_integration', $values['no_integration']);

    $config->set('cact_openbravo.sandbox',
      [
        'sandbox_enable' => (int)$values['sandbox_enable'],
        'customer_name' => $values['customer_name'],
        'customer_fiscal_name' => $values['customer_fiscal_name'],
        'customer_tax_id' => $values['customer_tax_id'],
        'customer_address_line1' => $values['customer_address_line1'],
        'customer_address_line2' => $values['customer_address_line2'],
        'customer_postal_code' => $values['customer_postal_code'],
        'customer_city' => $values['customer_city'],
        'customer_region_code' => $values['customer_region_code'],
        'customer_country_code' => $values['customer_country_code'],
      ]);

    $payment_gateway_storage = $this->entityTypeManager->getStorage('commerce_payment_gateway');
    $payments_gateways_storage = $payment_gateway_storage->loadMultiple();
    $payments_gateways = [];
    foreach($payments_gateways_storage as $index => $payment_gateway):
      $payments_gateways[$index] = $values[$index];
    endforeach;

    $config->set('cact_openbravo.payments_gateways', $payments_gateways);



    $config->save();
  }

}
