<?php

namespace Drupal\draco_universal_search\Normalizer;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Apple Universal Search Feed Item Normalizer.
 */
abstract class AppleUniversalSearchFeedItemNormalizer extends SerializerAwareNormalizer implements NormalizerInterface {

  /**
   * Format name.
   */
  const FORMAT = 'apple_us_catalog';

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

    if ($genres = $object->getGenres()) {
      $data['genre'] = $this->normalizeGenres($genres);
    }
    if ($ratings = $object->getRatings()) {
      $data['rating'] = $this->normalizeRatings($ratings);
    }
    if ($credits = $object->getCredits()) {
      $data['credits'] = $this->normalizeCredits($credits);
    }
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
   * Helper function to normalize genres.
   *
   * @param array $genres
   *   Array of genres from a content title entity.
   *
   * @return string
   *   Value for the genres element.
   */
  protected function normalizeGenres(array $genres) {
    // @todo this map may need work, I winged it quick.
    $map = [
      'Action' => 'action',
      'Adventure' => 'adventure',
      'Anthology' => 'short_films',
      'Based-on' => 'special_interest',
      'Biographical' => 'biography',
      'Black Comedy' => '',
      'Comedy' => 'comedy',
      'Crime' => 'crime',
      'Dance' => 'musical',
      'Disaster' => 'action',
      'Documentary' => 'documentary',
      'Drama' => 'drama',
      'Educational' => 'educational',
      'Family' => 'kids_and_family',
      'Horror' => 'horror',
      'Historical' => 'history',
      'Musical' => 'musical',
      'Mystery' => 'mystery',
      'Religious' => 'special_interest',
      'Romance' => 'romance',
      'Science Fiction' => 'sci_fi',
      'Short' => 'short_films',
      'Suspense' => 'action',
      'Thriller' => 'action',
      'War' => 'action',
    ];

    $apple_genres = [];
    foreach ($genres as $genre) {
      if (isset($map[$genre->Name])) {
        $apple_genres[] = $map[$genre->Name];
      }
    }
    return implode(',', $apple_genres);
  }

  /**
   * Helper function to normalize ratings.
   *
   * @param array $ratings
   *   Array of ratings from a content title entity.
   *
   * @return array
   *   Array of normalized ratings.
   */
  protected function normalizeRatings(array $ratings) {
    $rating_system_map = [
      'MPAA' => 'mpaa',
      'US' => 'us-tv',
    ];
    $ratings_added = [];

    $apple_ratings = [];
    foreach ($ratings as $rating_group) {
      if (isset($rating_group->RatingSystem) && in_array($rating_group->RatingSystem, array_keys($rating_system_map)) && !empty($rating_group->RatingDescriptors)) {
        foreach ($rating_group->RatingDescriptors as $rating_descriptor) {
          if (isset($rating_descriptor->Rating) && !in_array($rating_descriptor->Rating, $ratings_added)) {
            $ratings_added[] = $rating_descriptor->Rating;
            $apple_ratings[] = [
              '@systemCode' => $rating_system_map[$rating_group->RatingSystem],
              '#' => $rating_descriptor->Rating,
            ];
          }
        }
      }
    }
    return $apple_ratings;
  }

  /**
   * Helper function to normalize credits.
   *
   * @param array $credits
   *   Array of credits from a content title entity.
   *
   * @return array
   *   Array of normalized credits.
   */
  protected function normalizeCredits(array $credits) {
    // @todo this may need some work, Titles has a huge list of roles whereas Apple has a very limited one, as such many people end up in 'other'
    $role_map = [
      'Actor' => 'actor',
      'Director' => 'director',
      'Writer' => 'writer',
      'Producer' => 'producer',
      'Creator' => 'creator',
      'Voice' => 'voice',
      'Narrator' => 'narrator',
      'Guest' => 'guest',
      'Host' => 'host',
      'Anchor' => 'anchor',
      'Music' => 'music',
    ];

    $apple_credits = [];
    foreach ($credits as $credit) {
      if (!empty($credit->Name)) {
        $apple_credits[] = [
          '@role' => !empty($credit->RoleType) && isset($role_map[$credit->RoleType]) ? $role_map[$credit->RoleType] : 'other',
          '#' => $credit->Name,
        ];
      }
    }
    return $apple_credits;
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
