<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie;

/**
 * Movie normalizer for Apple Universal Search XML feed.
 */
class AppleUniversalSearchFeedItemMovieNormalizer extends AppleUniversalSearchFeedItemNormalizer {

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie $object */
    $data = parent::normalize($object, $format, $context);
    $data['movieInfo'] = [
      'type' => $object->getMovieType(),
      'duration' => $object->getDuration(),
    ];
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    return $format === static::FORMAT && $data instanceof UniversalSearchFeedItemMovie;
  }

}
