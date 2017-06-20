<?php

namespace Drupal\draco_universal_search\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * Roku Universal Search Feed Item Normalizer.
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
      '@id' => $object->getId(),
      'titles' => [
        'title' => $object->getTitle(),
      ],
      'descriptions' => [
        'description' => $object->getDescription(),
      ],
      'runTime' => $object->getDuration(),
    ];
    if ($credits = $object->getCredits()) {
      $data = array_merge($data, $this->normalizeCredits($credits));
    }
    if ($offers = $object->getOffers()) {
      $data['video']['viewOptions']['option'] = $this->normalizeOffers($offers);
    }
    // @todo finish other fields
    return $data;
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
    $cast_map = [
      'Actor' => 'actor',
      'Anchor' => 'anchor',
      'Guest' => 'guest',
      'Host' => 'host',
      'Narrator' => 'narrator',
      'Voice' => 'voice',
    ];
    $crew_map = [
      'Director' => 'director',
      'Writer' => 'writer',
      'Producer' => 'producer',
      'Creator' => 'creator',
      'Music' => 'music',
    ];

    $roku_credits = [];
    foreach ($credits as $credit) {
      if (!empty($credit->Name)) {
        if (isset($credit->RoleType) && in_array($credit->RoleType, array_keys($cast_map))) {
          $roku_credits['cast']['person'][] = [
            // @todo parse first, last, and middle name ...
            'firstName' => $credit->Name,
            'role' => $cast_map[$credit->RoleType],
          ];
        }
        else {
          $person = [
            // @todo parse first, last, and middle name ...
            'firstName' => $credit->Name,
          ];
          if (isset($credit->RoleType)) {
            //$person['role'] = $crew_map[$credit->RoleType] ?? 'Other';
			$person['role'] = isset($crew_map[$credit->RoleType]) ? $crew_map[$credit->RoleType] : 'Other';
          }
          $roku_credits['crew']['person'][] = $person;
        }
      }
    }
    return $roku_credits;
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
    $roku_offers = [];
    foreach ($offers as $offer) {
      $roku_offer = [
        'quality' => $offer->getVideoQuality(),
        'license' => $offer->getType(),
      ];
      if ($price = $offer->getPrice()) {
        $roku_offer['price'] = $price;
      }
      if ($currency = $offer->getCurrency()) {
        $roku_offer['currency'] = $currency;
      }
      $roku_offers[] = $roku_offer;
    }
    return $roku_offers;
  }

}
