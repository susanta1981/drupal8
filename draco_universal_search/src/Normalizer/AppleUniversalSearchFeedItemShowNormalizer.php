<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemShow;

/**
 * Movie normalizer for Apple Universal Search XML feed.
 */
class AppleUniversalSearchFeedItemShowNormalizer extends AppleUniversalSearchFeedItemNormalizer {

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemShow $object */
    $show_normalized = parent::normalize($object, $format, $context);
    $show_normalized['tvShowInfo'] = [
      'type' => $object->getShowType(),
    ];
    return array_merge([$show_normalized], $this->normalizeChildren($object, $format, $context));
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    return $format === static::FORMAT && $data instanceof UniversalSearchFeedItemShow;
  }

}
