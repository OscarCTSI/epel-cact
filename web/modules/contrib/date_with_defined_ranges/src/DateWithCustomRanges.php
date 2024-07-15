<?php

namespace Drupal\date_with_defined_ranges;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\datetime\Plugin\views\filter\Date;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Implementation of custom date range.
 *
 * @ViewsFilter("date_with_defined_range")
 */
class DateWithCustomRanges extends Date {

  /**
   * Type of processed date.
   *
   * @var string
   */
  protected $type;


  /**
   * Instance of ModuleHandler subsystem.
   *
   * @var \Drupal\Core\Extension\ModuleHandler
   */
  protected $moduleHandler;

  /**
   * Generate list of date range options.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup[]
   *
   * @throws \Drupal\Core\DependencyInjection\ContainerNotInitializedException
   * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
   * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
   */
  protected function buildDatesList() {
    $output = [
      'this_month' => $this->t('This Month'),
      'last_month' => $this->t('Last Month'),
      'last_three_months' => $this->t('Last Three Months'),
      'this_year' => $this->t('This Year'),
      'last_year' => $this->t('Last Year'),
      'custom' => $this->t('Custom'),
    ];

    // Invoke alter hook. This will allow to register new date definitions.
    $this->getModuleHandler()
      ->alter('date_custom_ranges_list', $output);

    return $output;
  }

  /**
   * Convert range argument to array with min / max value of time range.
   *
   * @param mixed $range
   *
   * @return array|null
   */
  protected function convertRangeToTime($range) {
    $now = time();
    $date_min = DrupalDateTime::createFromTimestamp($now);
    $date_max = DrupalDateTime::createFromTimestamp($now);
    $output = [];

    switch ($range) {
      case 'this_month':
        $output = [
          'min' => $date_min->modify('first day of this month')->format("U"),
          'max' => $date_max->modify('last day of this month')->format("U"),
        ];
        break;

      case 'last_three_months':
        $output = [
          'min' => $date_min->modify('-3 months')->modify('first day of this month')->format("U"),
          'max' => $date_max->modify('-1 month')->modify('last day of this month')->format("U"),
        ];
        break;

      case 'last_month':
        $output = [
          'min' => $date_min->modify('first day of last month')->format("U"),
          'max' => $date_max->modify('last day of last month')->format("U"),
        ];
        break;

      case 'this_year':
        $output = [
          'min' => $date_min->modify('first day of January')->format("U"),
          'max' => $date_max->modify('last day of December')->format("U"),
        ];
        break;

      case 'last_year':
        $output = [
          'min' => $date_min->modify("-1 year")->modify('first day of January')->format("U"),
          'max' => $date_max->modify("-1 year")->modify('last day of December')->format("U"),
        ];
        break;
    }

    // Invoke alter hook. This will allow to register new date definistions.
    $this->getModuleHandler()
      ->alter('date_custom_ranges_calculate', $output, $range);

    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function buildExposedForm(&$form, FormStateInterface $form_state) {
    parent::buildExposedForm($form, $form_state);
    // Build the form and set the value based on the identifier.
    if (!empty($this->options['expose']['identifier'])) {
      $date_filter_id = $this->options['expose']['identifier'];
    }

    // If we have filter id and we have enabled override...
    if (
      $date_filter_id &&
      $this->options['expose']['use_defined_ranges'] &&
      $this->options['operator'] === 'between'
    ) {
      $form[$date_filter_id . '_wrapper']['#type'] = 'fieldset';

      $form[$date_filter_id . '_wrapper'][$date_filter_id]['date_range'] = [
        '#type' => 'select',
        '#title' => $this->t('Range'),
        '#weight' => -5,
        '#empty_option' => $this->t('Please select date range.'),
        '#options' => $this->buildDatesList(),
      ];

      $range_field_selector = ":input[name='{$date_filter_id}[date_range]']";

      $form[$date_filter_id . '_wrapper'][$date_filter_id]['max']['#states'] = [
        'visible' => [
          $range_field_selector => ['value' => 'custom'],
        ],
      ];

      $form[$date_filter_id . '_wrapper'][$date_filter_id]['min']['#states'] = [
        'visible' => [
          $range_field_selector => ['value' => 'custom'],
        ],
      ];
    }

  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {

    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('date.formatter'),
      $container->get('request_stack'),
      $container->get('module_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, DateFormatterInterface $date_formatter, RequestStack $request_stack, ModuleHandlerInterface $module_handler) {
    // If we use entity field, make sure parent is happy about it.
    if (!isset($configuration['field_name'])) {
      $configuration['field_name'] = $configuration['entity field'];
    }

    parent::__construct($configuration, $plugin_id, $plugin_definition, $date_formatter, $request_stack);

    $this->moduleHandler = $module_handler;

    $definition = $this->getFieldStorageDefinition();

    // If it's not a regular date field, use numeric value for that.
    if (is_null($definition->getSetting('datetime_type'))) {
      $this->dateFormat = "U";
      $this->type = 'numeric';
    }
    else {
      $this->type = 'date';
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validateExposed(&$form, FormStateInterface $form_state) {
    $date_filter_id = NULL;
    $values = NULL;
    $computed_date_range = NULL;

    // Build the form and set the value based on the identifier.
    if (!empty($this->options['expose']['identifier'])) {
      $date_filter_id = $this->options['expose']['identifier'];
      $values = $form_state->getValue($date_filter_id);
    }

    if (!empty($values) && isset($values['date_range']) && $values['date_range'] !== 'custom') {
      $computed_date_range = $this->convertRangeToTime($values['date_range']);
    }

    if ($this->type === 'numeric') {
      $values['min'] = intval(strtotime($this->value['min'], 0));
      $values['max'] = intval(strtotime($this->value['max'], 0));
      $form_state->setValue($date_filter_id, $values);
    }

    if (is_array($computed_date_range) && !empty($computed_date_range)) {
      $values['min'] = DrupalDateTime::createFromTimestamp($computed_date_range['min'])->format($this->dateFormat);
      $values['max'] = DrupalDateTime::createFromTimestamp($computed_date_range['max'])->format($this->dateFormat);
      $form_state->setValue($date_filter_id, $values);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['expose']['contains']['use_defined_ranges'] = ['default' => ''];

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultExposeOptions() {
    parent::defaultExposeOptions();
    $this->options['expose']['use_defined_ranges'] = FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function buildExposeForm(&$form, FormStateInterface $form_state) {
    parent::buildExposeForm($form, $form_state);
    $form['expose']['use_defined_ranges'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use defined date ranges for this field.'),
      '#size' => 40,
      '#default_value' => $this->options['expose']['use_defined_ranges'],
    ];
  }

  /**
   *
   */
  protected function opBetween($field) {
    if ($this->type === 'numeric') {
      $this->opNumericBetween($field);
    }
    else {
      parent::opBetween($field);
    }
  }

  /**
   * OpBetween for numeric version of date.
   */
  protected function opNumericBetween($field) {
    $a = $this->value['min'];
    $b = $this->value['max'];

    // This is safe because we are manually scrubbing the values.
    // It is necessary to do it this way because $a and $b are formulas when using an offset.
    $operator = strtoupper($this->operator);
    $this->query->addWhereExpression($this->options['group'], "$field $operator $a AND $b");
  }

}
