<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemSeason;

/**
 * Movie normalizer for Apple Universal Search XML feed.
 */
class AppleUniversalSearchFeedItemSeasonNormalizer extends AppleUniversalSearchFeedItemNormalizer {

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemSeason $object */
    $season_normalized = parent::normalize($object, $format, $context);
    $season_normalized['tvSeasonInfo'] = [
      'showContentId' => $object->getShowId(),
      'seasonNumber' => $object->getSeasonNumber(),
    ];
    return array_merge([$season_normalized], $this->normalizeChildren($object, $format, $context));
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    return $format === static::FORMAT && $data instanceof UniversalSearchFeedItemSeason;
  }

}
