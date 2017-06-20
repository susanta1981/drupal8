<?php

namespace Drupal\draco_universal_search\Event;

use Drupal\draco_udi\Entity\ContentTitleInterface;
use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem;
use Symfony\Component\EventDispatcher\Event;

/**
 * Wraps a build feed item event for event subscribers.
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
 * Each feed consists of a number of items (movies, shows, seasons, and
 * episodes), which are represented by UniversalSearchFeedItem (note that each
 * item type also has a sub-type) objects. This event allows subscribers to
 * modify/augment feed item properties given the content title they were based
 * on.
 */
class BuildFeedItemEvent extends Event {

  /**
   * Universal search feed item.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   */
  protected $feedItem;

  /**
   * Content title entity.
   *
   * @var \Drupal\draco_udi\Entity\ContentTitleInterface
   */
  protected $contentTitle;

  /**
   * FeedItemBuiltEvent constructor.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem $feed_item
   *   Feed item.
   * @param \Drupal\draco_udi\Entity\ContentTitleInterface $content_title
   *   Content title.
   */
  public function __construct(UniversalSearchFeedItem $feed_item, ContentTitleInterface $content_title) {
    $this->feedItem = $feed_item;
    $this->contentTitle = $content_title;
  }

  /**
   * Get feed item.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem
   *   Feed item.
   */
  public function getFeedItem() {
    return $this->feedItem;
  }

  /**
   * Get content title entity.
   *
   * @return \Drupal\draco_udi\Entity\ContentTitleInterface
   *   Content title entity.
   */
  public function getContentTitle() {
    return $this->contentTitle;
  }

}
