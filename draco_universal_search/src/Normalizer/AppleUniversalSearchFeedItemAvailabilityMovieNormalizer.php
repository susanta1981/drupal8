<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie;

/**
 * Movie normalizer for Apple Universal Search XML feed.
 */
class AppleUniversalSearchFeedItemMovieNormalizer extends AppleUniversalSearchFeedItemAvailabilityNormalizer {

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie $object */
    $data = parent::normalize($object, $format, $context);
    $data['playableProperties'] = [
      'closedCaptioning' => 'fr-CA,fr-FR',
      'subtitles' => 'fr-CA,fr-FR',
      'subtitlesForDeaf' => 'fr-CA,fr-FR',
      'audioDescriptions' => 'fr-CA,fr-FR',
      'additionalAudioLang' => 'fr-FR',
      'audioFormats' => 'DD5.1,AAC',
      'primaryLocale' => 'en-US',
      'videoQuality' => 'hd',
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
