<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie;

/**
 * Movie normalizer for Roku Universal Search XML feed.
 */
class RokuUniversalSearchFeedItemMovieNormalizer extends RokuUniversalSearchFeedItemNormalizer {

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie $object */
    $data = parent::normalize($object, $format, $context);
    // @todo fill out movie specific fields.
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    return $format === static::FORMAT && $data instanceof UniversalSearchFeedItemMovie;
  }

}
