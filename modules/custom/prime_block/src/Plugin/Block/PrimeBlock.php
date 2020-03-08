<?php

namespace Drupal\prime_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block for executing PHP code.
 *
 * @Block(
 *   id = "prime_block",
 *   admin_label = @Translation("Prime Date Block")
 * )
 */
class PrimeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
//   protected function blockAccess(AccountInterface $account) {
//     return AccessResult::allowedIfHasPermission($account, 'execute php code');
//   }
 
  public function build() {
    $nodes = $this->getNodes();


    return [
        '#theme' => 'prime_block',
        '#nodes' => $nodes,
    ];
   
  }


  

  function getNodes() {
    $query = \Drupal::entityQuery('node')->condition('type', 'article')
      // limit query to only 30 results, sort in descending order 
      ->range(0, 30)->sort('created' , 'DESC');
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');

    $nids = $query->execute();
    $nodes = $node_storage->loadMultiple($nids);
    $result = [];
    foreach ($nodes as $n) {
      (int) $day =  date('d', $n->getCreatedTime());
      // check if day is odd
      if( !($day % 2 == 0)) {
        $created = date("F j, Y, g:i a", $n->getCreatedTime());
        $post_title = $n->title->value;
        $result[] = array("title" => $post_title, "created_date" => $created);
      }

    }

    // limit results to the most recent 5 articles from odd days
    return array_slice($result, 0, 5);
     
  }


}
