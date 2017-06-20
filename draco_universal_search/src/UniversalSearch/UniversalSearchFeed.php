<?php

namespace Drupal\draco_universal_search\UniversalSearch;

/**
 * Class which represents a Universal Search feed.
 */
class UniversalSearchFeed {

  /**
   * Feed items including Movies, Shows, Seasons, Episodes, etc.
   *
   * @var \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem[]
   */
  protected $items;

  /**
   * Team id.
   *
   * @var string
   */
  protected $teamId;

  /**
   * Human readable feed name, for descriptive purposes.
   *
   * @var string
   */
  protected $name;

  /**
   * Feed id.
   *
   * @var string
   */
  protected $id;

  /**
   * Default locale. The locale should be specified in BCP-47 format.
   *
   * @var string
   */
  protected $defaultLocale;

  /**
   * Service id.
   *
   * @var string
   */
  protected $serviceId;

  /**
   * Service type.
   *
   * @var string
   */
  protected $serviceType;

  /**
   * UniversalSearchFeed constructor.
   */
  public function __construct() {
    $this->items = [];
  }

  /**
   * {@inheritdoc}
   */
  public function getCount() {
    $count = 0;
    foreach ($this->items as $item) {
      $count += $item->getCount();
    }
    return $count;
  }

  /**
   * Get feed items.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem[]
   *   Feed items.
   */
  public function getItems() {
    return $this->items;
  }

  /**
   * Add an item to the feed.
   *
   * @param \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeedItem $item
   *   Universal feed object to add to this feed.
   */
  public function addItem(UniversalSearchFeedItem $item) {
    $this->items[] = $item;
  }

  /**
   * Get team id.
   *
   * @return string
   *   Team id.
   */
  public function getTeamId() {
    return $this->teamId;
  }

  /**
   * Set team id.
   *
   * @param string $teamId
   *   Team id.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   *   Fluid API return.
   */
  public function setTeamId(string $teamId) {
    $this->teamId = $teamId;
    return $this;
  }

  /**
   * Get feed name.
   *
   * @return string
   *   Feed name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set feed name.
   *
   * @param string $name
   *   Feed name.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   *   Fluid API return.
   */
  public function setName(string $name) {
    $this->name = $name;
    return $this;
  }

  /**
   * Get feed id.
   *
   * @return string
   *   Feed id.
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set feed id.
   *
   * @param string $id
   *   Feed id.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   *   Fluid API return.
   */
  public function setCatalogId(string $id) {
    $this->id = $id;
    return $this;
  }

  /**
   * Get default locale.
   *
   * @return string
   *   Default locale.
   */
  public function getDefaultLocale() {
    return $this->defaultLocale;
  }

  /**
   * Set default locale.
   *
   * @param string $defaultLocale
   *   Default locale.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   *   Fluid API return.
   */
  public function setDefaultLocale(string $defaultLocale) {
    $this->defaultLocale = $defaultLocale;
    return $this;
  }

  /**
   * Get service id.
   *
   * @return string
   *   Service id.
   */
  public function getServiceId(): string {
    return $this->serviceId;
  }

  /**
   * Set service id.
   *
   * @param string $serviceId
   *   Service id.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   *   Fluent API return.
   */
  public function setServiceId(string $serviceId) {
    $this->serviceId = $serviceId;
    return $this;
  }

  /**
   * Get service type.
   *
   * @return mixed
   *   Service type.
   */
  public function getServiceType() {
    return $this->serviceType;
  }

  /**
   * Set service tyep.
   *
   * @param mixed $serviceType
   *   Service type.
   *
   * @return \Drupal\draco_universal_search\UniversalSearch\UniversalSearchFeed
   *   Fluent API return.
   */
  public function setServiceType($serviceType) {
    $this->serviceType = $serviceType;
    return $this;
  }

}
