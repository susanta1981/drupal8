<?php

namespace Drupal\draco_universal_search\UniversalSearch;

/**
 * Season feed item, which may have one or more episodes.
 */
class UniversalSearchFeedItemSeason extends UniversalSearchFeedItem {

  /**
   * Show id.
   *
   * @var string
   */
  protected $showId;

  /**
   * Season number.
   *
   * @var int
   */
  protected $seasonNumber;

  /**
   * Get show id.
   *
   * @return string
   *   Show id.
   */
  public function getShowId() {
    return $this->showId;
  }

  /**
   * Set show id.
   *
   * @param string $showId
   *   Show id.
   *
   * @return UniversalSearchFeedItemSeason
   *   Fluid API return.
   */
  public function setShowId(string $showId) {
    $this->showId = $showId;
    return $this;
  }

  /**
   * Get season number.
   *
   * @return int
   *   Season number.
   */
  public function getSeasonNumber() {
    return $this->seasonNumber;
  }

  /**
   * Set season number.
   *
   * @param int $seasonNumber
   *   Season number.
   *
   * @return UniversalSearchFeedItemSeason
   *   Fluid API return.
   */
  public function setSeasonNumber(int $seasonNumber) {
    $this->seasonNumber = $seasonNumber;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getContentType() {
    return $this->contentType ?? static::CONTENT_TYPE_SEASON;
  }

}
