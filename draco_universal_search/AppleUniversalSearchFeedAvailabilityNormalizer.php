<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed;
use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Roku Universal Search Feed Normalizer.
 */
class AppleUniversalSearchFeedAvailabilityNormalizer extends SerializerAwareNormalizer implements NormalizerInterface {

  /**
   * Format name.
   */
  const FORMAT = 'apple_us_availability';

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed $object */
    $data = [
      '@version' => '2.0',
      'teamId' => $object->getTeamId(),
      'serviceId' => $object->getServiceId(),
      'serviceType' => $object->getServiceType(),
      'lastBuildDate' => date('c', REQUEST_TIME),
      'totalItemCount' => $object->getCount(),
    ];
    
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    return $format === static::FORMAT && $data instanceof UniversalSearchFeed;
  }

}
