<?php

namespace Drupal\cact_openbravo;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Url;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

/**
 * Class CactOpenbravoConnection
 *
 * @package Drupal\cact_openbravo
 */
class CactOpenbravoConnection {

  /**
   * @var \Drupal\Core\Config\Config Cact Openbravo settings
   */
  protected $config  = NULL;

  /**
   * @var array Store API headers.
   */
  protected $headers = [];

  /**
   * @var array Store API body.
   */
  protected $body = [];

  /**
   * Cact Openbravo constructor.
   */
  public function __construct() {
    $this->config = \Drupal::config('cact_openbravo.settings');
  }

  /**
   * Get configuration or state setting for this Cact Openbravo integration module.
   *
   * @param string $name this module's config or state.
   *
   * @return mixed
   */
  protected function getConfig($name) {
    return $this->config->get('cact_openbravo.' . $name);
  }

  /**
   * Call the Cact Openbravo API endpoint.
   *
   * @param string $endpoint
   * @param string $method
   * @param array $query
   *
   * @return array
   * @throws \GuzzleHttp\Exception\ServerException
   * @throws \GuzzleHttp\Exception\ClientException
   */
  public function callEndpoint($endpoint, $method, $query = []) {
    $this->setHeader();
    $body = $this->body;
    $url = $this->requestUrl($endpoint, $query)
      ->toString(); 
    $client  = \Drupal::httpClient();
    $response = NULL;
    $data = NULL;

    try {

      $response = $client->request($method, $url, [
        'headers' => $this->headers,
        'json' => $body
      ]);

      if ($endpoint == 'login') {
        $data['authorization'] = $response->getHeader('authorization');
      }
      else {
        $data = Json::decode($response->getBody()->getContents());
      }
    } catch (ServerException $e) {
      // Handle their server-side errors.
      watchdog_exception('cact_openbravo', $e);

      return [
        'response' => [
          'status_code' => $e->getResponse()->getStatusCode(),
          'message' => $e->getMessage()
        ]
      ];
    } catch (ClientException $e) {
      // Handle client-side error (e.g., authorization failures).
      watchdog_exception('cact_openbravo', $e);

      return [
        'response' => [
          'status_code' => $e->getResponse()->getStatusCode(),
          'message' => $e->getMessage()
        ]
      ];
    } catch (\Exception $e) {
      // Handle general PHP exceptions.
      watchdog_exception('cact_openbravo', $e);

      return [
        'response' => [
          'status_code' => $e->getCode(),
          'message' => $e->getMessage()
        ]
      ];
    }

    return [
      'response' => [
        'status_code' => $response->getStatusCode()
      ],
      'data' => $data
    ];
  }

  /**
   * Build the URI part of the URL based on the endpoint and configuration.
   *
   * @param string $endpoint to the API data
   *
   * @return string
   */
  protected function requestUri($endpoint) {
    $version = $this->getConfig('version');

    return $version . '/' . $endpoint;
  }

  /**
   * Build a Url object of the URL data to query the CACT Openbravo API.
   *
   * @param string $endpoint to the API data
   * @param array $query to build the URL query
   *
   * @return \Drupal\Core\Url
   */
  protected function requestUrl($endpoint, $query = []) {
    $url = $this->getConfig('url');
    $request_uri = $this->requestUri($endpoint);
    return Url::fromUri($url . $request_uri, [
      'query' => $query,
    ]);
  }

  /**
   * Build an array of headers to pass to the Cact Openbravo API.
   *
   * @param array $headers
   *
   * @return array
   */
  public function setHeader() {
    $this->headers = [
        'user' => $this->getConfig('user'),
        'password' => $this->getConfig('password'),
        'Content-Type' => 'application/json',
      ];
  }

  /**
   * Build an array of body values to pass to the Cact Openbravo API.
   *
   * @param array $body
   *
   * @return array
   */
  public function generateBody($body) {
    $this->body = $body;

    return $this->body;
  }

}
