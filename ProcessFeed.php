<?php

namespace Drupal\process_feed\Plugin\QueueWorker;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Run Queue worker via manual action.
 *
 * @QueueWorker(
 *   id = "process_feed",
 *   title = @Translation("Process Feed"),
 * )
 */
class ProcessFeed extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  /**
   * The node storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $nodeStorage;

  /**
   * Creates a new NodePublishBase object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $node_storage
   *   The node storage.
   */
  public function __construct(EntityStorageInterface $node_storage) {
    $this->nodeStorage = $node_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $container->get('entity_type.manager')->getStorage('node')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  protected function deleteNode($node) {
    if ($node && $node instanceof NodeInterface) {
      return $this->nodeStorage->delete($node);
    }
	return FALSE;
  }
  
  /**
   * {@inheritdoc}
   */
  protected function updateNode($node, $data) {
    if ($node && $node instanceof NodeInterface) {
      $node->field_airing_id->value = $data->airingID;
	  return $node->save();
    }
	return FALSE;
  }
  
  /**
   * {@inheritdoc}
   */
  protected function createNode($data) {
    //code to be implement for create new node
	return TRUE;
  }
  
  /**
   * {@inheritdoc}
   */
  protected function getNodeByAiringId($airing_id) {
    $query = $this->nodeStorage->getQuery();
	$nids = $query->condition('field_airing_id', $airing_id)->execute();
	return empty($nids) ?  FALSE : $this->nodeStorage->load(current($nids));
  }
  
  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    /** @var NodeInterface $node */
    $node = $this->getNodeByAiringId($data->airingID);
	switch($data->action) {
	  case 'Modify':
	    return $this->updateNode($node, $data);
		break;
	  case 'Delete':
	    return $this->deleteNode($node);
		break;
	  default:
        return $this->createNode($data);
        break;		
	}
  }
  
}
