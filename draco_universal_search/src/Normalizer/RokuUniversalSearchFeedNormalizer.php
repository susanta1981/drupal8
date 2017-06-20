<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed;
use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Roku Universal Search Feed Normalizer.
 */
class RokuUniversalSearchFeedNormalizer extends SerializerAwareNormalizer implements NormalizerInterface {

  /**
   * Format name.
   */
  const FORMAT = 'roku_us';

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed $object */
    $data = [];
    foreach ($object->getItems() as $item) {
      switch ($item->getContentType()) {
        case UniversalSearchFeedItem::CONTENT_TYPE_MOVIE:
          $data['movies']['movie'][] = $this->serializer->normalize($item, static::FORMAT, $context);
          break;
      }
    }

    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function supportsNormalization($data, $format = NULL) {
    return $format === static::FORMAT && $data instanceof UniversalSearchFeed;
  }

}
