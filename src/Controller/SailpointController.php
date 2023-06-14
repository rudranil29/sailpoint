<?php
namespace Drupal\sailpoint\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Drupal\Component\Serialization\Json;

/**
 * Provides route responses for the sailpoint module.
 */
class SailpointController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function get_pullrequest() {
    $pull_requests = [];

    $api_url   = \Drupal::config('sailpoint.settings')->get('api_url');
    $api_token = \Drupal::config('sailpoint.settings')->get('api_token');
    $client = \Drupal::httpClient();
    $response = $client->request('GET', $api_url, [
    'headers' => [
        'Accept' => 'application/vnd.github+json',
        'Authorization' => 'Bearer '. $api_token,
        'X-GitHub-Api-Version' => '2022-11-28'
    ]
    ]);

  try {
      $pull_requests = Json::decode($response->getBody(), TRUE);

    }
    catch (RequestException $e) {
    }

    return [
      '#theme' => 'sailpoint_design_template',
      '#pull_request' => $pull_requests,
    ];
    
  }
}
