<?php

namespace Drupal\draco_universal_search;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;

/**
 * Adds Universal Search custom formats.
 *
 * @internal
 */
class DracoUniversalSearchServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    if ($container->has('http_middleware.negotiation') && is_a($container->getDefinition('http_middleware.negotiation')
      ->getClass(), '\Drupal\Core\StackMiddleware\NegotiationMiddleware', TRUE)
    ) {
      $container->getDefinition('http_middleware.negotiation')
        ->addMethodCall('registerFormat', [
          'apple_us_catalog',
          ['text/xml'],
        ])
        ->addMethodCall('registerFormat', [
          'roku_us',
          ['text/xml'],
        ])
        ->addMethodCall('registerFormat', [
          'apple_us_availability',
          ['text/xml'],
        ]);
    }
  }

}
