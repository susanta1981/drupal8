<?php

namespace Drupal\draco_universal_search\Plugin\rest\resource;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchBuilder;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Universal Search feed.
 *
 * @RestResource(
 *   id = "universal_search_feed",
 *   label = @Translation("Universal Search Feed"),
 *   uri_paths = {
 *     "canonical" = "/universal-search-feed"
 *   }
 * )
 */
class UniversalSearchResource extends ResourceBase {

  /**
   * Universal Search builder.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchBuilder
   */
  protected $builder;

  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchBuilder $builder
   *   Universal Search builder.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    UniversalSearchBuilder $builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->builder = $builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('draco_universal_search'),
      $container->get('draco_universal_search.feed_builder')
    );
  }

  /**
   * Responds to GET requests.
   *
   * Returns a Universal Search Feed.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function get() {

    // Build the feed. This is a generic object model representing a super set
    // of data that is required to generate a feed for all known providers.
    $feed = $this->builder->build();

    return new ResourceResponse($feed);
  }

}
