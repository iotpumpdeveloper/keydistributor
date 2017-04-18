<?php
namespace KeyDistributor;

class WeightedKeyDistributor extends KeyDistributor 
{
  private $nodeIndexSearchAlgorithm = "";

  public function __construct($nodes)
  {
    $this->nodes = $nodes;
  }

  public function setNodeIndexSearchAlgorithm($algorithmName)
  {
    $this->nodeIndexSearchAlgorithm = $algorithmName;
    unset($this->algorithmPreparationDone);
  }

  public function getNodeForKey($key)
  {
    if ($this->nodeIndexSearchAlgorithm == "BinarySearch") {
      $numOfNodes = count($this->nodes);

      if (!isset($this->algorithmPreparationDone) ) {
        $this->algorithmPreparationDone = true;
        
        $maxIndex = 0;
        for ($i = 0; $i < $numOfNodes; $i++) {
          $maxIndex += $this->nodes[$i]['weight'] - 1; 
          $this->nodes[$i]['max_index'] = $maxIndex;
          $this->nodes[$i]['min_index'] = $maxIndex - $this->nodes[$i]['weight'] + 1;
        }

        $this->setNumOfNodes($maxIndex);
      }

      $virtualIndex = $this->getNodeIndexForKey($key);

      //now start binary search 
      $left = 0;
      $right = $numOfNodes;

      $searchCounter = 0;
      while(true) {
        $realIndex = (int)(($left + $right)/2);
        $searchCounter ++;
        if ( 
          ($virtualIndex <= $this->nodes[$realIndex]['max_index'] && $virtualIndex >= $this->nodes[$realIndex]['min_index']) 
        ) {
          return $this->nodes[$realIndex]['name']; 
          break;
        }  else if ($virtualIndex > $this->nodes[$realIndex]['max_index']) {
          $left = (int) (($left + $right) / 2);
        } else if ($virtualIndex < $this->nodes[$realIndex]['min_index']) {
          $right = (int) (($right + $left) / 2);
        } 
      }

    } else {
      $actualNodes = array();
      if (!isset($this->algorithmPreparationDone)) {
        $this->algorithmPreparationDone = true;
        foreach($this->nodes as $node) {
          $arr = array_fill(0, $node['weight'], $node['name']);
          $actualNodes = array_merge($actualNodes, $arr);
        }
        $this->setNumOfNodes(count($actualNodes));
      }  
      $index = $this->getNodeIndexForKey($key);
      return $actualNodes[$index];
    }

  }
}
