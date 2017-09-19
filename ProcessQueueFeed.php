<?php
namespace Drupal\process_feed\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController.
 *
 * @package Drupal\process_feed\Controller
 */
class ProcessQueueFeed extends ControllerBase {
  /**
   * Execute.
   *
   * @return string
   */
  public function execute() {
	$queue = \Drupal::service('queue')->get('process_feed');
    $queue_worker = \Drupal::service('plugin.manager.queue_worker')->createInstance('process_feed');
    while($item = $queue->claimItem()) {
	  	  	try {
            $queue_worker->processItem($item->data);
            $queue->deleteItem($item);
          }
          catch (SuspendQueueException $e) {
            $queue->releaseItem($item);
            break;
          }
          catch (\Exception $e) {
            watchdog_exception('custom_queue_worker', $e);
          }
      }
    }
	
	return new JsonResponse(['msg' => $this->t('Itesms processed')]);
  }
}