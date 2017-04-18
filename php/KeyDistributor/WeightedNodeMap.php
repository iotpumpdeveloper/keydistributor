<?php
namespace KeyDistributor;

class WeightedNodeMap 
{
  private $nodeIndexSearchAlgorithm = "";

  public function __construct($nodes)
  {
    $this->nodes = $nodes;
    $this->distributor = new KeyDistributor();
  }

  public function setNodeSearchAlgorithm($algorithmName)
  {
    $this->nodeSearchAlgorithm = $algorithmName;
    unset($this->algorithmPreparationDone);
  }

  public function getNodeForKey($key)
  {
    if ($this->nodeSearchAlgorithm == "BinarySearch") {
      $numOfNodes = count($this->nodes);

      $nodesArr = array();

      if (!isset($this->algorithmPreparationDone) ) {
        $this->algorithmPreparationDone = true;
        
        $maxIndex = 0;
        foreach($this->nodes as $name => $node) {
          $maxIndex += $node['weight'] - 1;
          $node['name'] = $name; 
          $node['max_index'] = $maxIndex;
          $node['min_index'] = $maxIndex - $node['weight'] + 1;
          $nodesArr[] = $node;
        }

        $this->distributor->setNumOfNodes($maxIndex);
      }

      $virtualIndex = $this->distributor->getNodeIndexForKey($key);

      //now start binary search 
      $left = 0;
      $right = $numOfNodes;

      $searchCounter = 0;
      while(true) {
        $realIndex = (int)(($left + $right)/2);
        $searchCounter ++;
        if ( 
          ($virtualIndex <= $nodesArr[$realIndex]['max_index'] && $virtualIndex >= $nodesArr[$realIndex]['min_index']) 
        ) {
          return $nodesArr[$realIndex]['name']; 
          break;
        }  else if ($virtualIndex > $nodesArr[$realIndex]['max_index']) {
          $left = (int) (($left + $right) / 2);
        } else if ($virtualIndex < $nodesArr[$realIndex]['min_index']) {
          $right = (int) (($right + $left) / 2);
        } 
      }

    } else {
      $actualNodes = array();
      if (!isset($this->algorithmPreparationDone)) {
        $this->algorithmPreparationDone = true;
        foreach($this->nodes as $name => $node) {
          $arr = array_fill(0, $node['weight'], $name);
          $actualNodes = array_merge($actualNodes, $arr);
        }
        $this->distributor->setNumOfNodes(count($actualNodes));
      }  
      $virtualIndex = $this->distributor->getNodeIndexForKey($key);
      return $actualNodes[$virtualIndex];
    }

  }
}
