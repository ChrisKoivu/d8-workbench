<?php

namespace Drupal\news_accordion\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block for executing PHP code.
 *
 * @Block(
 *   id = "news_accordion_block",
 *   admin_label = @Translation("News Accordion Block")
 * )
 */
class NewsAccordionBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
//   protected function blockAccess(AccountInterface $account) {
//     return AccessResult::allowedIfHasPermission($account, 'execute php code');
//   }
 
  public function build() {
    $buildArray =  $this->buildAccordionArray();
    $nodes = $buildArray[0];
    $labels = $buildArray[1];

    return [
        '#theme' => 'news_accordion_block',
        '#nodes' => array($nodes),
        '#labels' => [$labels]
    ];
   
  }
  
    function buildAccordionArray() {       
        $arr = [];
        $tids = $this->getTaxonomyIds("test");
        if(!empty($tids)) {
          $terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);
          // group each node keyed by taxonomy term in a new array
          foreach($terms as $key => $term) {  
            $arr[] = $this->getNodesByTaxonomyTermIds($tids[$key]);
            //$arr[$term->name->value][] = $this->getNodesByTaxonomyTermIds($tids[$key]);
            $labels[] =  $term->name->value;
          }   
        }
        return [$arr, $labels];
    }



    // get all taxonomy ids belonging to a vocabulary 
    // returns empty array if no match 
    function getTaxonomyIds($vocabId) {
      $query = \Drupal::entityQuery('taxonomy_term');
      $query->condition('vid', $vocabId);
      $tids = $query->execute();
      return $tids;
      //$terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);
    }

    // return all nodes matching tid
    function getNodesByTaxonomyTermIds($termIds){
      //casting as array as php7
      $termIds = (array) $termIds;
      if(empty($termIds)){
        return NULL;
      }
    
      // look up unique related nodes in taxonomy index
      $query = \Drupal::database()->select('taxonomy_index', 'ti');
      $query->fields('ti', array('nid'));
      $query->condition('ti.tid', $termIds, 'IN');
      $query->distinct(TRUE);
      $result = $query->execute();
    
      if($nodeIds = $result->fetchCol()){
          return  \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($nodeIds);
      }
    
      return NULL;
    }
  

}
