<?php

namespace Drupal\draco_universal_search\Event;

use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed;
use Symfony\Component\EventDispatcher\Event;

/**
 * Wraps a feed built event for event subscribers.
 *
 * The Universal Search module converts all applicable content title entities
 * into a generic object module, implemented by UniversalSearchFeed* classes.
 * This object model represents a superset of the necessary data to generate
 * the required feeds for each known Universal Search provider.
 *
 * As we are using content title data as a basis for the feed object model,
 * the object model is incomplete. Notable gaps include offer data, locate
 * data and artwork, among others.
 *
 * Each feed may or may not have global properties, which is represented by a
 * UniversalSearchFeed object. This event allows subscribers to modify/augment
 * those global properties.
 */
class BuildFeedEvent extends Event {

  /**
   * Universal search feed.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   */
  protected $feed;

  /**
   * BuildFeedEvent constructor.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed $feed
   *   Universal search feed.
   */
  public function __construct(UniversalSearchFeed $feed) {
    $this->feed = $feed;
  }

  /**
   * Get Universal search feed object.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   *   Universal search feed object.
   */
  public function getFeed() {
    return $this->feed;
  }

}
