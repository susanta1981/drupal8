<?php

namespace Drupal\draco_universal_search\UniversalSearch;

/**
 * Movie feed item.
 */
class UniversalSearchFeedItemMovie extends UniversalSearchFeedItem {

  /**
   * Feature movie type.
   */
  const MOVIE_TYPE_FEATURE = 'feature';

  /**
   * Made for TV movie type.
   */
  const MOVIE_TYPE_TV_MOVIE = 'tv_movie';

  /**
   * Short film movie type.
   */
  const MOVIE_TYPE_SHORT = 'short';

  /**
   * Movie type.
   *
   * @var string
   */
  protected $movieType;

  /**
   * Movie version.
   *
   * @var string
   */
  protected $movieVersion;

  /**
   * Production country.
   *
   * @var string
   */
  protected $productionCountry;

  /**
   * Get movie type.
   *
   * @return string
   *   Movie type.
   */
  public function getMovieType() {
    return $this->movieType;
  }

  /**
   * Set movie type.
   *
   * @param string $movieType
   *   Movie type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie
   *   Fluid API return.
   */
  public function setMovieType(string $movieType) {
    $this->movieType = $movieType;
    return $this;
  }

  /**
   * Get movie version.
   *
   * @return string
   *   Movie version.
   */
  public function getMovieVersion() {
    return $this->movieVersion;
  }

  /**
   * Set movie version.
   *
   * @param string $movieVersion
   *   Movie version.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie
   *   Fluid API return.
   */
  public function setMovieVersion(string $movieVersion) {
    $this->movieVersion = $movieVersion;
    return $this;
  }

  /**
   * Get production country.
   *
   * @return string
   *   Production country.
   */
  public function getProductionCountry() {
    return $this->productionCountry;
  }

  /**
   * Set production country.
   *
   * @param string $productionCountry
   *   Production country.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie
   *   Fluid API return.
   */
  public function setProductionCountry(string $productionCountry) {
    $this->productionCountry = $productionCountry;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getContentType() {
    return $this->contentType ?? static::CONTENT_TYPE_MOVIE;
  }

}
