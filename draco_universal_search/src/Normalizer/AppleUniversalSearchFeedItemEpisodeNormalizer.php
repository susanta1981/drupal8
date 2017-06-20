<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode;

/**
 * Movie normalizer for Apple Universal Search XML feed.
 */
class AppleUniversalSearchFeedItemEpisodeNormalizer extends AppleUniversalSearchFeedItemNormalizer {

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode $object */
    $data = parent::normalize($object, $format, $context);
    $data['tvEpisodeInfo'] = [
      'type' => $object->getEpisodeType(),
      'showContentId' => $object->getShowId(),
      'seasonContentId' => $object->getSeasonId(),
      'seasonNumber' => $object->getSeasonNumber(),
      'episodeNumber' => $object->getEpisodeNumber(),
      'duration' => $object->getDuration(),
    ];
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    return $format === static::FORMAT && $data instanceof UniversalSearchFeedItemEpisode;
  }

}
