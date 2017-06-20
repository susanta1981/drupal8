<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Apple Universal Search Feed Normalizer.
 */
class AppleUniversalSearchFeedNormalizer extends SerializerAwareNormalizer implements NormalizerInterface {

  /**
   * Format name.
   */
  const FORMAT = 'apple_us_catalog';

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed $object */
    $data = [
      '@version' => '1.2',
      'teamId' => $object->getTeamId(),
      'totalItemCount' => $object->getCount(),
      'channel' => [
        'lastBuildDate' => date('c', REQUEST_TIME),
        'title' => (string) $object->getName(),
        'catalogId' => $object->getId(),
        'defaultLocale' => $object->getDefaultLocale(),
      ],
    ];

    $data['channel']['item'] = [];
    foreach ($object->getItems() as $item) {
      $item_serialized = $this->serializer->normalize($item, static::FORMAT, $context);
      // Check if the array is fully numeric keys. If so, it's a list of feed
      // items that we want to return together with what we've already got.
      if (ctype_digit(implode('', array_keys($item_serialized)))) {
        $data['channel']['item'] = array_merge($data['channel']['item'], $item_serialized);
      }
      else {
        $data['channel']['item'][] = $item_serialized;
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
