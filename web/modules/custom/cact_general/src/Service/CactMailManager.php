<?php

namespace Drupal\cact_general\Service;

use Drupal\Core\Datetime\Element\Datetime;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\easy_email_override\Service\MailManager;

/**
 * Class CactMailManager.
 *
 * Decorates the MailManager::mail method to apply Easy Email overrides.
 * Issue translations
 * https://www.drupal.org/project/easy_email/issues/3047790
 *
 * @package Drupal\cact_general
 */
class CactMailManager extends MailManager {

  /**
   * Decorated service object.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $decorated;


  /**
   * Constructs the EmailManager object.
   *
   * @param \Drupal\Core\Mail\MailManagerInterface $decorated
   * @param \Traversable $namespaces
   * @param ModuleHandlerInterface $module_handler
   */
  public function __construct(MailManagerInterface $decorated, \Traversable $namespaces, ModuleHandlerInterface $module_handler) {
    parent::__construct($decorated, $namespaces, $module_handler);
    $this->decorated = $decorated;
  }

  /**
   * @inheritDoc
   */
  public function getInstance(array $options) {
    return $this->decorated->getInstance($options);
  }


  public function getGCalendarUrl($event){
   // date_default_timezone_set('UTC');
    $titulo = urlencode($event['titulo']);
    $descripcion = urlencode($event['descripcion']);
    $localizacion = urlencode($event['localizacion']);
    $date_start = date( "Ymd\THis", strtotime($event['fecha_inicio'].''.$event['hora_inicio']));
    $date_end = date( "Ymd\THis", strtotime($event['fecha_fin'].''.$event['hora_fin']));
    $dates = $date_start . '/' . $date_end;
    $name = urlencode($event['nombre']);
    $url = urlencode($event['url']);
    $gCalUrl = "http://www.google.com/calendar/event?action=TEMPLATE&text=".$titulo."&dates=".$dates."&details=".$descripcion."&location=".$localizacion."&trp=false&sprop=".$url."&sprop=name:".$name."";
    return ($gCalUrl);
  }

  /**
   * @inheritDoc
   */
  public function mail($module, $key, $to, $langcode, $params = [], $reply = NULL, $send = TRUE) {
    $email_handler = \Drupal::service('easy_email.handler');
    /** @var \Drupal\easy_email_override\Entity\EmailOverrideInterface[] $email_overrides */
    $email_overrides = \Drupal::entityTypeManager()
      ->getStorage('easy_email_override')
      ->loadByProperties([
        'module' => $module,
        'key' => $key,
      ]);

    if (!empty($email_overrides)) {
      if($email_overrides['override_order_receipt']->getKey() == 'order_receipt'){
        $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
        $easy_email_type = \Drupal::entityTypeManager()
          ->getStorage('easy_email_type')
          ->load('complete_order_' . $language);
        if($easy_email_type){
          $email_overrides['override_order_receipt']->setEasyEmailType($easy_email_type->id());
        }
      }

      // If we find more than one override for a given module/key combo, we'll send them all.
      // Not sure if that will be useful, but perhaps.
      foreach ($email_overrides as $email_override) {
        $email = $email_handler->createEmail([
          'type' => $email_override->getEasyEmailType(),
        ]);
        $param_map = $email_override->getParamMap();
        foreach ($param_map as $pm) {
          $email->set($pm['destination'], $params[$pm['source']]);
        }
        $result = $email_handler->sendEmail($email);
        $send = FALSE;
      }
    }
    $message = $this->decorated->mail($module, $key, $to, $langcode, $params, $reply, $send);
    if (!isset($message['result']) && !empty($email_overrides)) {
      $message['result'] = TRUE;
    }

    return $message;
  }

}
