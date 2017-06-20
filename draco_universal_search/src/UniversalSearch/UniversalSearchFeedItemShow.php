<?php

namespace Drupal\draco_universal_search\UniversalSearch;

/**
 * Show feed item, which may have one or more seasons and/or episodes.
 */
class UniversalSearchFeedItemShow extends UniversalSearchFeedItem {

  /**
   * Series show type.
   */
  const SHOW_TYPE_SERIES = 'series';

  /**
   * Mini-series show type.
   */
  const SHOW_TYPE_MINISERIES = 'miniseries';

  /**
   * Show type.
   *
   * @var string
   */
  protected $showType;

  /**
   * Get show type.
   *
   * @return string
   *   Show type.
   */
  public function getShowType() {
    return $this->showType;
  }

  /**
   * Set show type.
   *
   * @param string $showType
   *   Show type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemShow
   *   Fluid API return.
   */
  public function setShowType($showType) {
    $this->showType = $showType;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getContentType() {
    return $this->contentType ?? static::CONTENT_TYPE_SHOW;
  }

}
