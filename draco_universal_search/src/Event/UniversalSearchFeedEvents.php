<?php

namespace Drupal\draco_universal_search\Event;

/**
 * Universal Search events.
 *
 * Defines the event names which are fired during the Universal Search Feed
 * rendering.
 */
final class UniversalSearchFeedEvents {

  /**
   * Name of the event fired when the Universal Search Feed has been built.
   *
   * @see \Drupal\draco_universal_search\Event\BuildFeedEvent
   */
  const BUILD_FEED = 'draco_universal_search.build_feed';

  /**
   * Name of the event fired when each Universal Search Feed item is built.
   *
   * @see \Drupal\draco_universal_search\Event\BuildFeedItemEvent
   */
  const BUILD_FEED_ITEM = 'draco_universal_search.build_feed_item';

}
