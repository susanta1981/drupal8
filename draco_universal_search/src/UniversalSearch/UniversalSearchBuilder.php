<?php

namespace Drupal\draco_universal_search\UniversalSearch;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\draco_udi\Entity\ContentTitleInterface;
use Drupal\draco_universal_search\Event\BuildFeedEvent;
use Drupal\draco_universal_search\Event\BuildFeedItemEvent;
use Drupal\draco_universal_search\Event\UniversalSearchFeedEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Base class for Universal Search Builders.
 */
class UniversalSearchBuilder {

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Simple config for the module.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Current request.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * Event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  /**
   * Array of show feed items we've created, keyed by content title id.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemShow[]
   */
  protected $shows;

  /**
   * Array of season feed items we've created.
   *
   * Since Seasons are not a content title record, we need to stub these out.
   * These will be keyed on the show content title id and season number
   * combined. With format <show_content_title_id>.<season_number>.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemSeason[]
   */
  protected $seasons;

  /**
   * Array of episode feed items we've created, keyed by content title id.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode[]
   */
  protected $episodes;

  /**
   * UniversalSearchBuilderBase constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manger
   *   Entity type manager.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config factory.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   Request stack.
   * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $event_dispatcher
   *   Event dispatcher.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manger, ConfigFactoryInterface $config_factory, RequestStack $request_stack, EventDispatcherInterface $event_dispatcher) {
    $this->entityTypeManager = $entity_type_manger;
    $this->config = $config_factory->get('draco_universal_search');
    $this->request = $request_stack->getCurrentRequest();
    $this->eventDispatcher = $event_dispatcher;
    $this->shows = $this->seasons = $this->episodes = [];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Setup feed object and set global properties.
    $feed = new UniversalSearchFeed();
    $feed->setTeamId('placeholder.team.id')
      ->setName('Placeholder - Universal Search Feed')
      ->setCatalogId('placeholder.catalog.id')
      ->setDefaultLocale($this->request->getLocale());

    // Loop through all the content titles and setup feed items based on each.
    foreach ($this->getContentTitles() as $content_title) {
      unset($feed_item);

      // Based on content type, build out the appropriate feed item object and
      // add it to the feed. We need a value for content type to proceed,
      // otherwise we can't know how to translate this item.
      if ($content_type = $content_title->getTitleType()) {
        // Movies.
        if ($content_type === 'Feature Film') {
          $feed_item = $this->buildMovie($feed, UniversalSearchFeedItemMovie::MOVIE_TYPE_FEATURE);
        }
        elseif ($content_type === 'Short') {
          $feed_item = $this->buildMovie($feed, UniversalSearchFeedItemMovie::MOVIE_TYPE_SHORT);
        }
        // TV Shows.
        elseif ($content_type === 'Series') {
          $feed_item = $this->buildSeries($feed, $content_title);
        }
        // TV Episodes.
        elseif ($content_type === 'Episode') {
          $feed_item = $this->buildEpisode($feed, $content_title);
        }

        // @todo cover any other types that are appropriate.

        // Build out all the common fields.
        if (isset($feed_item)) {
          $feed_item->setId($content_title->getTitleId())
            ->setChangedDate(date('c', $content_title->getChangedTime()))
            ->setTitle($content_title->label());
          if ($description = $this->getDescription($content_title)) {
            $feed_item->setDescription($description);
          }
          if ($genres = $content_title->getGenres()) {
            $feed_item->setGenres($content_title->getGenres());
          }
          if ($ratings = $content_title->getRatings()) {
            $feed_item->setRatings($ratings);
          }
          if ($participants = $content_title->getParticipants()) {
            $feed_item->setCredits($participants);
          }
          if ($duration = $content_title->getLengthInSeconds()) {
            $feed_item->setDuration($duration);
          }

          // @todo finish common fields.

          // Allow others to alter the feed item object.
          $event = new BuildFeedItemEvent($feed_item, $content_title);
          $this->eventDispatcher->dispatch(UniversalSearchFeedEvents::BUILD_FEED_ITEM, $event);
        }
      }
    }

    // Allow others to alter the feed object model. This is the primary way that
    // brands should augment the source data for the feed.
    $event = new BuildFeedEvent($feed);
    $this->eventDispatcher->dispatch(UniversalSearchFeedEvents::BUILD_FEED, $event);

    return $feed;
  }

  /**
   * Helper function to build a movie feed item.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed $feed
   *   Universal search feed.
   * @param string $type
   *   Movie type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemMovie
   *   Movie feed item.
   */
  protected function buildMovie(UniversalSearchFeed $feed, $type) {
    $feed_item = new UniversalSearchFeedItemMovie();
    $feed_item->setMovieType($type);
    $feed->addItem($feed_item);
    return $feed_item;
  }

  /**
   * Helper function to build a series feed item.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed $feed
   *   Universal search feed.
   * @param \Drupal\draco_udi\Entity\ContentTitleInterface $content_title
   *   Content title entitiy.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemShow
   *   Series feed item.
   */
  protected function buildSeries(UniversalSearchFeed $feed, ContentTitleInterface $content_title) {
    // Note stubs may have been created if an episode that references this
    // show was created first.
    if (isset($this->shows[$content_title->getTitleId()])) {
      $feed_item = $this->shows[$content_title->getTitleId()];
    }
    else {
      $feed_item = new UniversalSearchFeedItemShow();
      $feed->addItem($feed_item);
    }

    $feed_item->setShowType(UniversalSearchFeedItemShow::SHOW_TYPE_SERIES);

    return $feed_item;
  }

  /**
   * Helper function to build a episode feed item.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed $feed
   *   Universal search feed.
   * @param \Drupal\draco_udi\Entity\ContentTitleInterface $content_title
   *   Content title entitiy.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItemEpisode
   *   Episode feed item.
   */
  protected function buildEpisode(UniversalSearchFeed $feed, ContentTitleInterface $content_title) {
    $feed_item = new UniversalSearchFeedItemEpisode();
    $show_id = $content_title->getSeriesTitleId();
    $season_id = $content_title->getSeriesTitleId() . '.' . $content_title->getSeasonNumber();
    $season_number = $content_title->getSeasonNumber();
    $episode_number = $content_title->getSeasonEpisodeNumber() ?? $content_title->getSeriesItemNumber();

    // Simple fields.
    $feed_item->setEpisodeType(UniversalSearchFeedItemEpisode::EPISODE_TYPE_FULL);

    // Hierarchy data.
    $feed_item->setShowId($show_id);
    $feed_item->setSeasonId($season_id);
    $feed_item->setSeasonNumber($season_number);
    $feed_item->setEpisodeNumber($episode_number);

    // Create stub show object if necessary.
    if (!isset($this->shows[$show_id])) {
      $this->shows[$show_id] = new UniversalSearchFeedItemShow();
      $this->shows[$show_id]->setId($show_id);
      // Note that ee only need to add to the feed if the show parent of the
      // episode we are interested in here has not yet been added to the feed.
      // Since the object model is hierarchical, it's entirely possible that a
      // sibling episode already caused the parent show and season to be added
      // to the object model.
      $feed->addItem($this->shows[$show_id]);
    }
    // Create a stub season object if necessary.
    if (!isset($this->seasons[$season_id])) {
      $this->seasons[$season_id] = new UniversalSearchFeedItemSeason();
      $this->seasons[$season_id]->setId($season_id);
      $this->seasons[$season_id]->setShowId($show_id);
      $this->seasons[$season_id]->setSeasonNumber($season_number);
      $this->shows[$show_id]->addItem($this->seasons[$season_id]);
    }
    $this->seasons[$season_id]->addItem($feed_item);
    return $feed_item;
  }

  /**
   * Get the content titles.
   *
   * @todo probably want to expose this query so that brands can affect what titles make it into the feed.
   *
   * @return \Drupal\draco_udi\Entity\ContentTitleInterface[]
   *   Array of content title entities.
   */
  public function getContentTitles() {
    // Get all the content titles.
    $entity_storage = $this->entityTypeManager->getStorage('content_title');
    $query = $entity_storage->getQuery();
    // @todo paging?
    // @todo more conditions?
    $query
      ->condition('title_type', ['Feature Film', 'Episode'], 'IN')
      ->range(0, 100);
    $content_titles = [];
    if ($content_title_ids = $query->execute()) {
      $content_titles = $entity_storage->loadMultiple($content_title_ids);
    }
    return $content_titles;
  }

  /**
   * Get the long form description of the content title.
   *
   * @param \Drupal\draco_udi\Entity\ContentTitleInterface $content_title
   *   Content title object.
   *
   * @return string|null
   *   Long form description of the given content title.
   */
  protected function getDescription(ContentTitleInterface $content_title) {
    if ($description = $content_title->getExternalStoryline()) {
      return $description;
    }
    elseif ($storylines = $content_title->getStorylines()) {
      $storylines_by_type = [];
      foreach ($storylines as $storyline) {
        if (isset($storyline->Type)) {
          $storylines_by_type[$storyline->Type] = $storyline;
        }
      }
      // @todo there may be a different priority order here.
      $storyline_types = [
        'Turner External',
        'IMDB',
        'Baseline',
        'Short (245 Characters)',
      ];
      foreach ($storyline_types as $storyline_type) {
        if (!empty($storylines_by_type[$storyline_type]->Description)) {
          return $storylines_by_type[$storyline_type]->Description;
        }
      }
    }
  }

}
