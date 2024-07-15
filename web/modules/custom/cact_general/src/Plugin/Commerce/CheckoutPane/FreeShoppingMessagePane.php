<?php

namespace Drupal\cact_general\Plugin\Commerce\CheckoutPane;

use Drupal\commerce_checkout\Plugin\Commerce\CheckoutFlow\CheckoutFlowInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Utility\Token;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\commerce_checkout\Plugin\Commerce\CheckoutPane\CheckoutPaneBase;

/**
 * Provides the completion message pane.
 *
 * @CommerceCheckoutPane(
 *   id = "free_shopping_message_pane",
 *   label = @Translation("Free shopping completion message"),
 *   default_step = "complete",
 * )
 */
class FreeShoppingMessagePane extends CheckoutPaneBase {

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, CheckoutFlowInterface $checkout_flow = NULL) {
    $instance = new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $checkout_flow,
      $container->get('entity_type.manager')
    );
    $instance->setToken($container->get('token'));
    return $instance;
  }

  /**
   * Sets the token service.
   *
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   */
  public function setToken(Token $token) {
    $this->token = $token;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'free_shopping_message' => [
        'value' => "<p>[current-date:long]</p> <p>Te hemos enviado la confirmación de reservación y las entradas a tu correo electrónico. Por favor si no lo encuentras en la bandeja de entrada revisa si a podido entrar como SPAM. Muchas gracias.</p>",
        'format' => 'full_html',
      ],
    ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['free_shopping_message'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Message'),
      '#description' => $this->t('Shown the end of checkout, after the customer has placed their order.'),
      '#default_value' => $this->configuration['free_shopping_message']['value'],
      '#format' => $this->configuration['free_shopping_message']['format'],
      '#element_validate' => ['token_element_validate'],
      '#token_types' => ['commerce_order'],
      '#required' => TRUE,
    ];
    $form['token_help'] = [
      '#theme' => 'token_tree_link',
      '#token_types' => ['commerce_order'],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);

    if (!$form_state->getErrors()) {
      $values = $form_state->getValue($form['#parents']);
      $this->configuration['free_shopping_message'] = $values['free_shopping_message'];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildPaneForm(array $pane_form, FormStateInterface $form_state, array &$complete_form) {
    if ($this->order->getTotalPrice()->isZero() && $this->order->get('checkout_step')->value == 'complete') {
      $message = $this->token->replace($this->configuration['free_shopping_message']['value'], [
        'commerce_order' => $this->order,
      ]);
      $pane_form['free_shopping_message'] = [
        '#theme' => 'commerce_checkout_completion_message_free_purchase',
        '#order_entity' => $this->order,
        '#message' => [
          '#type' => 'processed_text',
          '#text' => $message,
          '#format' => $this->configuration['free_shopping_message']['format'],
          
        ],//checkout-pane-completion-message
        '#attributes' => ['class' => ['checkout-pane-completion-message']],
      ];
      return $pane_form;
    }
    return $pane_form;
  }

}
