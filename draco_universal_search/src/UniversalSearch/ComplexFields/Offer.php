<?php

namespace Drupal\draco_universal_search\UniversalSearch\ComplexFields;

use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Represents an offer of a feed item.
 *
 * An offer is a description of how the end user can obtain a copy of the media
 * of a given feed item. Each Universal Search Provider uses slightly
 * different nomenclature around offers. This class attempts to capture it all
 * in one place. See the documenation for each provider for more details. For
 * Apple see Availability Feed documentation on the offer element. For Roku,
 * see documentation on the ... video/viewOptions/option element
 * (https://sdkdocs.roku.com/display/sdkdoc/Roku+Search#RokuSearch-SearchMeta-Data).
 * For Amazon see documentation on the Offers element
 * (https://developer.amazon.com/public/solutions/devices/fire-tv/docs/catalog/catalog-data-format-schema-reference#Offers).
 */
class Offer {

  /**
   * Free acces.
   */
  const TYPE_FREE = 'free';

  /**
   * Subscription access.
   */
  const TYPE_SUBSCRIPTION = 'subscription';

  /**
   * Available for purchase.
   */
  const TYPE_PURCHASE = 'purchase';

  /**
   * Available for rent.
   */
  const TYPE_RENTAL = 'rental';

  /**
   * Standard definition video quality.
   */
  const QUALITY_SD = 'SD';

  /**
   * High definition video quality.
   */
  const QUALTY_HD = 'HD';

  /**
   * High definition plus video quality.
   */
  const QUALITY_HD_PLUS = 'HD+';

  /**
   * Offer type.
   *
   * @var string
   */
  protected $type;

  /**
   * Availability window start date.
   *
   * @var \Drupal\Core\Datetime\DrupalDateTime
   */
  protected $windowStart;

  /**
   * Availability window end date.
   *
   * @var \Drupal\Core\Datetime\DrupalDateTime
   */
  protected $windowEnd;

  /**
   * Price.
   *
   * @var float
   */
  protected $price;

  /**
   * Currency.
   *
   * @var string
   */
  protected $currency;

  /**
   * Amount of time in seconds the media is available to the user after access.
   *
   * Usually only applicable to rentals.
   *
   * @var int
   */
  protected $duration;

  /**
   * Video quality (SD, HD, 4K, etc.)
   *
   * @var string
   */
  protected $videoQuality;

  /**
   * Region (country) where this the media is available. Two character country
   * ISO code.
   *
   * @var string[]
   */
  protected $availableRegions;

  /**
   * Get offer type.
   *
   * @return string
   *   Offer type.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Set offer type.
   *
   * @param string $type
   *   Offer type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setType(string $type) {
    $this->type = $type;

    return $this;
  }

  /**
   * Get window start date.
   *
   * @return \Drupal\Core\Datetime\DrupalDateTime
   *   Window start date.
   */
  public function getWindowStart() {
    return $this->windowStart;
  }

  /**
   * Set window start date.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $windowStart
   *   Window start date.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setWindowStart(DrupalDateTime $windowStart) {
    $this->windowStart = $windowStart;
    return $this;
  }

  /**
   * Get window end date.
   *
   * @return \Drupal\Core\Datetime\DrupalDateTime
   *   Window end date.
   */
  public function getWindowEnd() {
    return $this->windowEnd;
  }

  /**
   * Set window end date.
   *
   * @param \Drupal\Core\Datetime\DrupalDateTime $windowEnd
   *   Window end date.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setWindowEnd(DrupalDateTime $windowEnd) {
    $this->windowEnd = $windowEnd;
    return $this;
  }

  /**
   * Get price.
   *
   * @return float
   *   Price.
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * Set price.
   *
   * @param float $price
   *   Price.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setPrice(float $price) {
    $this->price = $price;
    return $this;
  }

  /**
   * Get currency.
   *
   * @return string
   *   Currency.
   */
  public function getCurrency() {
    return $this->currency;
  }

  /**
   * Set currency.
   *
   * @param mixed $currency
   *   Currency.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setCurrency($currency) {
    $this->currency = $currency;
    return $this;
  }

  /**
   * Get duration.
   *
   * @return int
   *   Duration.
   */
  public function getDuration() {
    return $this->duration;
  }

  /**
   * Set duration.
   *
   * @param int $duration
   *   Duration in seconds.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setDuration(int $duration) {
    $this->duration = $duration;
    return $this;
  }

  /**
   * Get video quality.
   *
   * @return string
   *   Video quality.
   */
  public function getVideoQuality() {
    return $this->videoQuality;
  }

  /**
   * Set video quality.
   *
   * @param string $videoQuality
   *   Video quality.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setVideoQuality(string $videoQuality) {
    $this->videoQuality = $videoQuality;
    return $this;
  }

  /**
   * Get available regions.
   *
   * @return \string[]
   *   Array of country codes.
   */
  public function getAvailableRegions() {
    return $this->availableRegions;
  }

  /**
   * Set available regions.
   *
   * @param \string[] $availableRegions
   *   Array of country codes.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer
   *   Fluent API return.
   */
  public function setAvailableRegions(array $availableRegions) {
    $this->availableRegions = $availableRegions;
    return $this;
  }

}
