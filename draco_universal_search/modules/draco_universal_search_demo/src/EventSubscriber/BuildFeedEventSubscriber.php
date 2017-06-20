<?php

namespace Drupal\draco_universal_search_demo\EventSubscriber;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\draco_universal_search\Event\BuildFeedEvent;
use Drupal\draco_universal_search\Event\UniversalSearchFeedEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribe to the build feed event.
 *
 * The build feed event occurs after the object model for the Universal Search
 * feed has been built. This affords an opportunity to modify/augment the global
 * properties of the feed. This should rarely be necessary, more often what is
 * required is to modify/augment each individual feed item (movies, shows,
 * seasons, and episodes). To view an example of that see
 * FeedItemBuiltSubscriber.
 *
 * @see \Drupal\draco_universal_search_demo\EventSubscriber\FeedItemBuiltSubscriber
 */
class BuildFeedEventSubscriber implements EventSubscriberInterface {
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[UniversalSearchFeedEvents::BUILD_FEED][] = ['buildFeed'];
    return $events;
  }

  /**
   * Event handler for when the feed object model is built.
   *
   * @param \Drupal\draco_universal_search\Event\BuildFeedEvent $event
   *   Event object containing the feed object.
   */
  public function buildFeed(BuildFeedEvent $event) {
    $feed = $event->getFeed();
    // Here we override the name of the feed.
    $feed->setName($this->t('My custom name for the feed.'));
  }

}
