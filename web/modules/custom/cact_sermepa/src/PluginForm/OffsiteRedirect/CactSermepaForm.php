<?php

namespace Drupal\cact_sermepa\PluginForm\OffsiteRedirect;

use CommerceRedsys\Payment\Sermepa as SermepaApi;
use Drupal\commerce_payment\PluginForm\PaymentOffsiteForm as BasePaymentOffsiteForm;
use Drupal\commerce_sermepa\PluginForm\OffsiteRedirect\SermepaForm;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides the Sermepa/Redsýs class for the payment form.
 */
class CactSermepaForm extends SermepaForm {

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\commerce_payment\Entity\PaymentInterface $payment */
    $payment = $this->entity;

    $order = $payment->getOrder();

    /** @var \Drupal\commerce_payment\Plugin\Commerce\PaymentGateway\OffsitePaymentGatewayInterface $payment_gateway_plugin */
    $payment_gateway_plugin = $payment->getPaymentGateway()->getPlugin();

    // Get the gateway settings.
    $gateway_settings = $payment_gateway_plugin->getConfiguration();
    $merchant_consumer_language = $payment_gateway_plugin->getUnknowFallbackLanguage();

    // Create a new instance of the Sermepa library and initialize it.
    try {
      $gateway = new SermepaApi($gateway_settings['merchant_name'], $gateway_settings['merchant_code'], $gateway_settings['merchant_terminal'], $gateway_settings['merchant_password'], $payment_gateway_plugin->getMode());

      // Configure the gateway transaction.
      $date = DrupalDateTime::createFromTimestamp($this->time->getRequestTime());

      $parameters = FALSE;
      // Check if the payment currency code and the payment method settings are
      // the same.
      $currency_code = $payment->getAmount()->getCurrencyCode();
      /** @var \Drupal\commerce_price\Entity\CurrencyInterface $currency */
      $currency = $this->entityTypeManager->getStorage('commerce_currency')->load($currency_code);

      if ($currency->getNumericCode() == $gateway_settings['currency']) {
        // Prepare the amount converting 120.00 or 120 to 12000.
        $amount = $payment->getAmount()->multiply(100)->getNumber();
        $gateway->setAmount($amount)
          ->setCurrency($gateway_settings['currency'])
          ->setOrder(substr($date->format('ymdHis') . 'Id' . $order->id(), -12, 12))
          ->setMerchantMerchantGroup($gateway_settings['merchant_group'])
          ->setPaymentMethod(implode('', $gateway_settings['merchant_paymethods']))
          ->setConsumerLanguage($merchant_consumer_language)
          ->setMerchantData($order->id())
          ->setTransactionType($gateway_settings['transaction_type'])
          ->setMerchantURL($payment_gateway_plugin->getNotifyUrl()->toString())
          ->setUrlKO($form['#cancel_url'])
          ->setUrlOK($form['#return_url']);

        // if collect billing information is enabled  then send customer data to payment gateway
        if ($payment_gateway_plugin->collectsBillingInformation() && ($profile = $payment->getOrder()->getBillingProfile())):

          $titular = $profile->address->given_name . " " . $profile->address->family_name;
          $mail = $payment->getOrder()->getEmail();
          $titular .= " (" . $mail . ")";

          // Titular parameter max length = 60
          $gateway->setTitular(strlen($titular) > 60 ? substr($titular, 0, 60) : $titular);

        endif;


        // Get the transaction fields for the sermepa form.
        $parameters = $gateway->composeMerchantParameters();
      }
    }
    catch (\Exception $exception) {
      watchdog_exception('commerce_sermepa', $exception);
    }

    if (empty($parameters)) {
      $this->messenger->addError($this->t('An error has been occurred trying of process the payment data, please contact with us.'));

      return $this->redirectToPaymentInformationPane($order);
    }

    $data = [
      'Ds_SignatureVersion' => $gateway->getSignatureVersion(),
      'Ds_MerchantParameters' => $parameters,
      'Ds_Signature' => $gateway->composeMerchantSignature(),
    ];

    return $this->buildRedirectForm($form, $form_state, $gateway->getEnvironment(), $data, BasePaymentOffsiteForm::REDIRECT_POST);
  }

}
