<?php

namespace Drupal\draco_universal_search\UniversalSearch;

use Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer;

/**
 * A Universal Search feed item.
 *
 * This is an abstraction of all the Universal Search vendors.
 */
class UniversalSearchFeedItem {

  /**
   * Movie content type.
   */
  const CONTENT_TYPE_MOVIE = 'movie';

  /**
   * Show content type.
   */
  const CONTENT_TYPE_SHOW = 'tv_show';

  /**
   * Season content type.
   */
  const CONTENT_TYPE_SEASON = 'tv_season';

  /**
   * Episode content type.
   */
  const CONTENT_TYPE_EPISODE = 'tv_episode';

  /**
   * Feed items including Movies, Shows, Seasons, Episodes, etc.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem[]
   */
  protected $items;

  /**
   * Content type.
   *
   * @var string
   */
  protected $contentType;

  /**
   * Feed item id.
   *
   * @var string
   */
  protected $id;

  /**
   * Change date.
   *
   * @var string
   */
  protected $changed;

  /**
   * Title.
   *
   * @var string
   */
  protected $title;

  /**
   * Description.
   *
   * @var string
   */
  protected $description;

  /**
   * Genres.
   *
   * @var array
   */
  protected $genres;

  /**
   * Ratings.
   *
   * @var array
   */
  protected $ratings;

  /**
   * Credits.
   *
   * @var array
   */
  protected $credits;

  /**
   * External content id.
   *
   * @var string
   */
  protected $externalContentId;

  /**
   * External content id scheme.
   *
   * @var string
   */
  protected $externalContentIdScheme;

  /**
   * Image URL.
   *
   * @var string
   */
  protected $imageUrl;

  /**
   * Image type.
   *
   * @var string
   */
  protected $imageType;

  /**
   * Source.
   *
   * @var string
   */
  protected $source;

  /**
   * Offers.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer[]
   */
  protected $offers;

  /**
   * Short description.
   *
   * @var string
   */
  protected $shortDescription;

  /**
   * Duration in seconds.
   *
   * @var int
   */
  protected $duration;

  /**
   * Studios.
   *
   * @var array
   */
  protected $studios;

  /**
   * Release date.
   *
   * @var string
   */
  protected $releaseDate;

  /**
   * UniversalSearchFeedItem constructor.
   */
  public function __construct() {
    $this->items = [];
    $this->offers = [];
  }

  /**
   * {@inheritdoc}
   */
  public function getCount() {
    $count = 1;
    foreach ($this->items as $item) {
      $count += $item->getCount();
    }
    return $count;
  }

  /**
   * Get all the feed items that are children of this one.
   *
   * @return array|\Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem[]
   *   Child feed items.
   */
  public function getItems() {
    return $this->items;
  }

  /**
   * Add a feed item to the children of this feed item.
   *
   * Only some feed items, like shows and seasons have child items.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem $item
   *   Item to add to this feed item.
   */
  public function addItem(UniversalSearchFeedItem $item) {
    $this->items[] = $item;
  }

  /**
   * Get content type.
   *
   * @return string
   *   Content type.
   */
  public function getContentType() {
    return $this->contentType;
  }

  /**
   * Set content type.
   *
   * @param string $contentType
   *   Content type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setContentType(string $contentType) {
    $this->contentType = $contentType;
    return $this;
  }

  /**
   * Get id.
   *
   * @return string
   *   Id.
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set id.
   *
   * @param string $id
   *   Id.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setId(string $id) {
    $this->id = $id;
    return $this;
  }

  /**
   * Get changed date.
   *
   * @return string
   *   Changed date.
   */
  public function getChanged() {
    return $this->changed;
  }

  /**
   * Set changed date.
   *
   * @param string $changed
   *   Changed date.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setChangedDate(string $changed) {
    $this->changed = $changed;
    return $this;
  }

  /**
   * Get title.
   *
   * @return string
   *   Title.
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Set title.
   *
   * @param string $title
   *   Title.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setTitle(string $title) {
    $this->title = $title;
    return $this;
  }

  /**
   * Get description.
   *
   * @return string
   *   Description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Set description.
   *
   * @param string $description
   *   Description.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setDescription(string $description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Get genres.
   *
   * @return array
   *   Array of genre labels.
   */
  public function getGenres() {
    return $this->genres;
  }

  /**
   * Set genres.
   *
   * @param array $genres
   *   Array of genre labels.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setGenres(array $genres) {
    $this->genres = $genres;
    return $this;
  }

  /**
   * Get ratings.
   *
   * @return array
   *   Array of ratings following the array strucutre given by Titles. See
   *   http://titles.turner.com/Reference/Index/11.
   */
  public function getRatings() {
    return $this->ratings;
  }

  /**
   * Set ratings.
   *
   * @param array $ratings
   *   Array of ratings. Follows the array structure given by Titles. See
   *   http://titles.turner.com/Reference/Index/11.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setRatings(array $ratings) {
    $this->ratings = $ratings;
    return $this;
  }

  /**
   * Get credits.
   *
   * @return array
   *   Array of credits following the array structure given by Titles. See
   *   http://titles.turner.com/Reference/Index/15 for more information.
   */
  public function getCredits() {
    return $this->credits;
  }

  /**
   * Set credits.
   *
   * @param array $credits
   *   Array of credits following the array structure given by Titles. See
   *   http://titles.turner.com/Reference/Index/15 for more information.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setCredits(array $credits) {
    $this->credits = $credits;
    return $this;
  }

  /**
   * Get external content id.
   *
   * @return string
   *   External content id.
   */
  public function getExternalContentId() {
    return $this->externalContentId;
  }

  /**
   * Set external content id.
   *
   * @param string $externalContentId
   *   External content id.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setExternalContentId(string $externalContentId) {
    $this->externalContentId = $externalContentId;
    return $this;
  }

  /**
   * Get external content id scheme.
   *
   * @return string
   *   External content id scheme.
   */
  public function getExternalContentIdScheme() {
    return $this->externalContentIdScheme;
  }

  /**
   * Set external content id scheme.
   *
   * @param string $externalContentIdScheme
   *   External content id scheme.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setExternalContentIdScheme(string $externalContentIdScheme) {
    $this->externalContentIdScheme = $externalContentIdScheme;

    return $this;
  }

  /**
   * Get image URL.
   *
   * @return string
   *   Image URL.
   */
  public function getImageUrl() {
    return $this->imageUrl;
  }

  /**
   * Set image URL.
   *
   * @param string $imageUrl
   *   Image URL.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setImageUrl(string $imageUrl) {
    $this->imageUrl = $imageUrl;

    return $this;
  }

  /**
   * Get image type.
   *
   * @return string
   *   Image type.
   */
  public function getImageType() {
    return $this->imageType;
  }

  /**
   * Set image type.
   *
   * @param string $imageType
   *   Image type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setImageType(string $imageType) {
    $this->imageType = $imageType;
    return $this;
  }

  /**
   * Get source.
   *
   * @return string
   *   Source.
   */
  public function getSource() {
    return $this->source;
  }

  /**
   * Set source.
   *
   * Where the work originated.
   *
   * @param string $source
   *   One of original, licensed, unknown, or other.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   *
   * @throws \UnexpectedValueException
   *   For invalid source value.
   */
  public function setSource(string $source) {
    if (!in_array($source, [
      'original',
      'licensed',
      'unknown',
      'other',
    ])) {
      throw new \UnexpectedValueException('Invalid value for source. Must be one of original, licensed, unknown, or other');
    }
    $this->source = $source;
    return $this;
  }

  /**
   * Get offers.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer[]
   *   Array of offers.
   */
  public function getOffers() {
    return $this->offers;
  }

  /**
   * Set offers.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer $offer
   *   Array of offers.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function addOffer(Offer $offer) {
    $this->offers[] = $offer;
    return $this;
  }

  /**
   * Get short description.
   *
   * One or two sentance description of the feed item.
   *
   * @return string
   *   Short description.
   */
  public function getShortDescription() {
    return $this->shortDescription;
  }

  /**
   * Set short description.
   *
   * @param string $shortDescription
   *   Short description.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setShortDescription(string $shortDescription) {
    $this->shortDescription = $shortDescription;
    return $this;
  }

  /**
   * Get duration.
   *
   * Returns the duration in seconds.
   *
   * @return int
   *   Duration in seconds.
   */
  public function getDuration() {
    return $this->duration;
  }

  /**
   * Set duration in seconds.
   *
   * @param string $duration
   *   Duration in seconds.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setDuration(string $duration) {
    $this->duration = $duration;
    return $this;
  }

  /**
   * Get studios.
   *
   * @todo figure out a common format for studios.
   *
   * @return array
   *   Array of studios.
   */
  public function getStudios() {
    return $this->studios;
  }

  /**
   * Set studios.
   *
   * @param array $studios
   *   Array of studios.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setStudios(array $studios) {
    $this->studios = $studios;
    return $this;
  }

  /**
   * Get release date.
   *
   * @return string
   *   Release date.
   */
  public function getReleaseDate() {
    return $this->releaseDate;
  }

  /**
   * Set release date.
   *
   * @param string $releaseDate
   *   Set release date.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Fluid API return.
   */
  public function setReleaseDate(string $releaseDate) {
    $this->releaseDate = $releaseDate;
    return $this;
  }

}
