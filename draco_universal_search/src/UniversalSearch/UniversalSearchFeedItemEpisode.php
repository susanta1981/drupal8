<?php

namespace Drupal\draco_universal_search\UniversalSearch;

/**
 * Episode feed item.
 */
class UniversalSearchFeedItemEpisode extends UniversalSearchFeedItem {

  /**
   * Full episode type.
   */
  const EPISODE_TYPE_FULL = 'full';

  /**
   * Episode type.
   *
   * @var string
   */
  protected $episodeType;

  /**
   * Show id.
   *
   * @var string
   */
  protected $showId;

  /**
   * Season id.
   *
   * @var string
   */
  protected $seasonId;

  /**
   * Season number.
   *
   * @var int
   */
  protected $seasonNumber;

  /**
   * Episode number.
   *
   * @var int
   */
  protected $episodeNumber;

  /**
   * Get episode type.
   *
   * @return string
   *   Episode type.
   */
  public function getEpisodeType() {
    return $this->episodeType;
  }

  /**
   * Set episode type.
   *
   * @param string $episodeType
   *   Episode type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode
   *   Fluid API return.
   */
  public function setEpisodeType(string $episodeType) {
    $this->episodeType = $episodeType;

    return $this;
  }

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
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode
   *   Fluid API return.
   */
  public function setShowId(string $showId) {
    $this->showId = $showId;
    return $this;
  }

  /**
   * Get season id.
   *
   * @return string
   *   Season id.
   */
  public function getSeasonId() {
    return $this->seasonId;
  }

  /**
   * Set season id.
   *
   * @param string $seasonId
   *   Season id.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode
   *   Fluid API return.
   */
  public function setSeasonId(string $seasonId) {
    $this->seasonId = $seasonId;
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
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode
   *   Fluid API return.
   */
  public function setSeasonNumber(int $seasonNumber) {
    $this->seasonNumber = $seasonNumber;
    return $this;
  }

  /**
   * Get episode number.
   *
   * @return int
   *   Episode number.
   */
  public function getEpisodeNumber() {
    return $this->episodeNumber;
  }

  /**
   * Set episode number.
   *
   * @param int $episodeNumber
   *   Episode number.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode
   *   Fluid API return.
   */
  public function setEpisodeNumber(int $episodeNumber) {
    $this->episodeNumber = $episodeNumber;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getContentType() {
    return $this->contentType ?? static::CONTENT_TYPE_EPISODE;
  }

}