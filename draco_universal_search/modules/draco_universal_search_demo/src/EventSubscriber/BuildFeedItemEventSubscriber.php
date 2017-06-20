<?php

namespace Drupal\draco_universal_search_demo\EventSubscriber;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\draco_universal_search\Event\BuildFeedItemEvent;
use Drupal\draco_universal_search\Event\UniversalSearchFeedEvents;
use Drupal\draco_universal_search\UniversalSearch\ComplexFields\Offer;
use Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribe to the feed item built event.
 */
class BuildFeedItemEventSubscriber implements EventSubscriberInterface {
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[UniversalSearchFeedEvents::BUILD_FEED_ITEM][] = ['buildFeedItem'];
    return $events;
  }

  /**
   * Event handler for when the feed object model has been built.
   *
   * @param \Drupal\draco_universal_search\Event\BuildFeedItemEvent $event
   *   Event object containing the feed item and the content title entity on
   *   which it was based.
   */
  public function buildFeedItem(BuildFeedItemEvent $event) {
    $feed_item = $event->getFeedItem();
    $content_title = $event->getContentTitle();

    // Here we set the title of the feed item to the entity label of the
    // content entity that was mapped from the content title entity. This
    // isn't a very useful example, as the label of the content entity, is the
    // same as the feed item title that was set. However, this demonstrates how
    // brands can use the mapped content entity to affect items in the feed.
    // Since the mapped content entity is typically something that is
    // editorially controlled, it's likely that that it has additional fields
    // (for example artwork) that you'll want to add to the Unniversal Search
    // Feed.
    $feed_item->setTitle($content_title->mapped_content->entity->label());

    // Here we conditionally set an offer. All movies are free! Obviously this
    // is a terrible idea, but it illustrates how this is a place where you can
    // add your business logic, or pull the pricing data from another source.
    if ($feed_item->getContentType() === UniversalSearchFeedItem::CONTENT_TYPE_MOVIE) {
      $offer = (new Offer())
        ->setType(Offer::TYPE_FREE)
        ->setAvailableRegions(['CA', 'US'])
        ->setVideoQuality('HD')
        // Free from the begining of UNIX time!
        ->setWindowStart(new DrupalDateTime(date('c', 0)))
        // Set a far future end date for the offer.
        ->setWindowEnd(new DrupalDateTime('2255-01-01T00:00:00'));
      $feed_item->addOffer($offer);
    }
  }

}
