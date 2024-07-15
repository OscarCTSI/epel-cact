<?php

namespace Drupal\cact_openbravo;


/**
 * Class CactOpenbravoServices
 *
 * @package Drupal\cact_openbravo
 */
class CactOpenbravoServices {

  const ENDPOINT_PRODUCTS = 'es.tomaticket.webservices.products';

  const ENDPOINT_STOCKS = 'es.tomaticket.webservices.stocks';

  const ENDPOINT_PRERESERVE = 'es.tomaticket.webservices.prereserve';

  const ENDPOINT_ORDERS = 'es.tomaticket.webservices.orders';


  /*
   * TODO
   * */
  const ENDPOINT_BUSINESS_PARTER = 'api/operations';

  /**
   * @var \Drupal\cact_openbravo\CactOpenbravoConnection Cact Openbravo Connection
   */
  protected $cactOpenbravoConnection  = NULL;


  /**
   * Cact Openbravo Servicesconstructor.
   */
  public function __construct(CactOpenbravoConnection $cact_openbravo_chainwood_connection) {
    $this->cactOpenbravoConnection = $cact_openbravo_chainwood_connection;
  }

  /**
   * Get product information
   *
   * @param string $product_id product id of openbravo
   *
   * @return mixed
   */
  public function getProduct($product_id) {
    $request = false;
    if(isset($product_id)){
      $request = $this->cactOpenbravoConnection->callEndpoint(self::ENDPOINT_PRODUCTS, 'GET', ['productId' => $product_id]);
      if(isset($request['data']['sucess'])){
        $request = $request;
      }
    }

    return $request;
  }



  /**
   * Get product stock information
   *
   * @param string $session_id session id of product openbravo
   *
   * @return mixed
   */
  public function getStocks($session_id = null, $parameters = []) {
    $data_request = false;
    $query = [];
    if (!is_null($session_id)) {
      $query['sessionId'] = $session_id; 
    }
    if ($parameters){
      $query = array_merge($query, $parameters);
    }
    
    $request = $this->cactOpenbravoConnection->callEndpoint(self::ENDPOINT_STOCKS, 'GET', $query);
    if (isset($request['data']['sucess'])) {
        $data_request = $request;
    } elseif (isset($request['response']['status_code']) && $request['response']['status_code'] === 200) {
        $data_request = $request;
    }
    
    return $data_request;
  }

  /**
   * Create/update/delete presererve
   *
   * @param array $data data of capacity or number
   *
   * Capacity:
   *  Create array index:
   *    "sessionId" => Session id of product ("CDB394C0D7D44D24B4E21D4CA5290420")
   *    "qty" => Number of person ("2")
   *  Update array index:
   *    "sessionId" => Session id of product ("CDB394C0D7D44D24B4E21D4CA5290420")
   *    "qty" => Number of person ("4")
   *    "reservationId" => reservationId of create request ("46D9A586DCEF44E580438A17539D4C3E")
   *  Delete array index:
   *    "sessionId" => Session id of product
   *    "qty" => Number of person equal to 0 ("0")
   *    "reservationId" => reservationId of create request ("46D9A586DCEF44E580438A17539D4C3E")
   *
   * Number:
   *  Create array index:
   *    "sessionId" => Session id of product ("E913F75E82174210971C3315AB474DDB")
   *    "locationNo" => Number of location from stock ("5")
   *    "prereserve" => Bollean true (create) (true)
   *  Update array index: // TODO
   *    "sessionId" => Session id of product
   *    "qty" => Number of person
   *    "reservationId" => reservationId of create request
   *  Delete array index:
   *    "sessionId" => Session id of product ("E913F75E82174210971C3315AB474DDB")
   *    "locationNo" => Number of location from stock ("5")
   *    "prereserve" => Bollean false (remove) (false)
   *
   * @return mixed
   *
   */
  public function createPrereserve($data) {
    $request = false;
    if(isset($data)){
      $this->cactOpenbravoConnection->generateBody($data);
      $request = $this->cactOpenbravoConnection->callEndpoint(self::ENDPOINT_PRERESERVE, 'POST');
      if(isset($request['data']['sucess'])){
        $request = $request;
      }
    }

    return $request;
  }

  /**
   * Create order
   *
   * @param array $data data of capacity or number
   *
   * Capacity:
   *  Array index:
   *     "tomaticketId" => Code of order from drupal ("TT324325"),
   *     "dateOrdered" => Date of creation order with format YYYY-MM-DD ("2021-08-17"),
   *     "customer" => [
   *        "name" => User name ("Hector Camps"),
   *        "fiscalName" => "",
   *        "taxid" => Identity document ("46466142R"),
   *        "address" => Address 1 "Calle Flores Xxx",
   *        "address2" => Address 2 "",
   *        "postal" => "35026",
   *        "city" => "Arrecife",
   *        "regionCode" => "35",
   *        "countryCode" => "ES"
   *     ],
   *     "grossAmount" => Total ammount (24.9),
   *     "paymentMethodCode" => Match with payment method ("PayPal"), TODO
   *     "lines" => [
   *      [
   *        "productId" => productID of product endpoint ("A106BAAFA4AC99ADB67A967ECEC0F27F"),
   *        "sessionId" => sessionID of product endpoint ("E913F75E82174210971C3315AB474DDB"),
   *        "qty" => Total persons(3),
   *        "grossPrice" => 24.9,
   *        "passNumbers" => [ TODO
   *          "zzz",
   *          "eee",
   *          "kkk"
   *        ],
   *        "reservationId" => ReservationID of prereserve ("61DE0C1D1BAB4B6399D51FD6B325B9E4")
   *      ]
   *    ]
   *
   * Number:
   *     "tomaticketId" => "TT324324",
   *     "dateOrdered" => "2021-08-17",
   *     "customer" => [
   *      "name" => "Hector Camps",
   *      "fiscalName" => "",
   *      "taxid" => "46466142R",
   *      "address" => "Calle Flores Xxx",
   *      "address2" => "",
   *      "postal" => "35026",
   *      "city" => "Arrecife",
   *      "regionCode" => "35",
   *      "countryCode" => "ES"
   *    ],
   *    "grossAmount" => 24.9,
   *    "paymentMethodCode" => "PayPal",
   *    "lines" => [
   *      [
   *        "productId" => "A106BAAFA4AC99ADB67A967ECEC0F27F",
   *        "sessionId" => "DE8324BB02D54F69AEE56F71825794DF",
   *        "qty" => 3,
   *        "grossPrice" => 24.9,
   *        "passNumbers" => [
   *          "xxxx",
   *          "yyyyy",
   *          "oooo"
   *        ],
   *        "locationsNo" => [
   *          "3",
   *          "7",
   *          "8"
   *        ]
   *      ]
   *   ]
   *
   * @return mixed
   *
   */
  public function order($data) {
    $request = false;
    if(isset($data)){
      $json_datos = json_encode($data);
      $this->cactOpenbravoConnection->generateBody($data);
      
      $request = $this->cactOpenbravoConnection->callEndpoint(self::ENDPOINT_ORDERS, 'POST');
      if(isset($request['data']['sucess'])){
        $request = $request;
      }
    }

    return $request;
  }

}
