<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Apple Universal Search Feed Item Normalizer.
 */
abstract class AppleUniversalSearchFeedItemAvailabilityNormalizer extends SerializerAwareNormalizer implements NormalizerInterface {

  /**
   * Format name.
   */
  const FORMAT = 'apple_us_availability';

  /**
   * {@inheritdoc}
   */
  public function normalize($object, $format = NULL, array $context = array()) {
    /** @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem $object */
    $data = [
      'contentType' => $object->getContentType(),
      'contentId' => $object->getId(),
      'pubDate' => $object->getChanged(),
      'title' => $object->getTitle(),
    ];
    
    if ($offers = $object->getOffers()) {
      $data['offer'] = $this->normalizeOffers($offers);
    }

    return $data;
  }

  /**
   * Helper function to normalize the children of a given feed item.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem $feed_item
   *   Feed item.
   * @param string $format
   *   Format the normalization result will be encoded as.
   * @param array $context
   *   Context options for the normalizer.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem[]
   *   Array of serialized feed items.
   */
  protected function normalizeChildren(UniversalSearchFeedItem $feed_item, $format, array $context) {
    $children_normalized = [];
    foreach ($feed_item->getItems() as $child_item) {
      $normalized = $this->serializer->normalize($child_item, $format, $context);
      // Check if the array is fully numeric keys. If so, it's a list of feed
      // items that we want to return together with what we've already got.
      if (ctype_digit(implode('', array_keys($normalized)))) {
        $children_normalized = array_merge($children_normalized, $normalized);
      }
      else {
        $children_normalized[] = $normalized;
      }
    }
    return $children_normalized;
  }

  /**
   * Helper function to normalize offers.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer[] $offers
   *   Array of offers.
   *
   * @return array
   *   Array of normalized offers.
   */
  protected function normalizeOffers(array $offers) {
    $apple_offers = [];
    foreach ($offers as $offer) {
      $apple_offers[] = [
        'offerType' => $offer->getType(),
        'windowStart' => $offer->getWindowStart()->format('c'),
        'windowEnd' => $offer->getWindowEnd()->format('c'),
      ];
    }
    return $apple_offers;
  }

}
