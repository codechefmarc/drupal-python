<?php

namespace Drupal\ai\Controller;

use Drupal\Core\Controller\ControllerBase;
use GuzzleHttp\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ExampleController.
 */
class ExampleController extends ControllerBase {

  /**
   * The HTTP client to fetch the URL.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * Constructs a new ExampleController object.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client to fetch the URL.
   */
  public function __construct(Client $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client')
    );
  }

  /**
   * Fetches a URL and returns the response body.
   *
   * @return array
   *   A render array containing the response body.
   */
  public function fetch() {
    $url = 'http://python.lndo.site/process';
    $testString = "I love cheese, especially cottage cheese st. agur blue cheese. Emmental when the cheese comes out everybody's happy airedale bocconcini fondue everyone loves caerphilly manchego. Lancashire croque monsieur cauliflower cheese ricotta caerphilly hard cheese mascarpone danish fontina.";
    try {
      $response = $this->httpClient->post($url, [
        'json' => [
          'string_to_test' => $testString,
        ],
      ],);
      //kint(json_decode($response->getBody()->__toString(), TRUE));
      $body = json_decode($response->getBody()->__toString(), TRUE)['data'];
    }
    catch (\Exception $e) {
      $body = $this->t('An error occurred: @message', ['@message' => $e->getMessage()]);
    }

    return [
      '#type' => 'markup',
      '#theme' => 'ai_tokenizer',
      '#test_string' => $testString,
      '#num_tokens' => $body['num_tokens'],
      '#encoded' => $body['encoded'],
    ];
  }

}
