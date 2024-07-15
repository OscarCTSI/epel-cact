<?php

namespace Drupal\cact_order_item_print;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\encrypt\EncryptService;

/**
 * Class AesOrdeItem
 *
 * @package Drupal\cact_order_item_print
 */
class AesOrderItem
{

  const INSTANCE_ID = 'order_items';

  /**
   * Encrypt service.
   *
   * @var \Drupal\encrypt\EncryptService
   */
  protected $encrypt;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * AesOrderItem constructor.
   * @param EncryptService $encrypt
   * @param EntityTypeManagerInterface $entity_type_manager
   */
  public function __construct(EncryptService $encrypt, EntityTypeManagerInterface $entity_type_manager)
  {
    $this->encrypt = $encrypt;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Returh path of pdf order_item
   * */
  public function getStringPathOrderItemPdf($code, $absolute = true, $group = false){
    if(!$group){
      $parameters = ["hash_code" => $this->encryptCodeOrderItem($code)];
    }else{
      $parameters = ["hash_code" => $this->encryptCodeOrderItem($code), 'group' => 1];
    }
    return \Drupal::urlGenerator()->generateFromRoute('cact_order_item_print.print_order',$parameters, ['absolute' => $absolute]);
  }

  /*
   * Return URL Object
   * */
  public function getObjectUrl($code, $group = false){
    if(!$group){
      $parameters = ["hash_code" => $this->encryptCodeOrderItem($code)];
    }else{
      $parameters = ["hash_code" => $this->encryptCodeOrderItem($code), 'group' => 1];
    }
    return Url::fromRoute('cact_order_item_print.print_order',$parameters);
  }

  /*
   * Return encrypt from code
   * */
  private function encryptCodeOrderItem($code){
    return $this->encrypt->encrypt($code, $this->encryptionProfile());
  }

  /*
   * Return decrypt from code
   * */
  public function decryptCodeOrderItem($code){
    return $this->encrypt->decrypt($code, $this->encryptionProfile());
  }

  /*
   * Return encryption profile
   * */
  private function encryptionProfile(){
    return $this->entityTypeManager->getStorage('encryption_profile')->load(self::INSTANCE_ID);
  }

  /*
   * Return qr code image
   * */
  public function getQrCode($code){
    $options = new QROptions(
      [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
      ]
    );

    return (new QRCode($options))->render($code);
  }
}
