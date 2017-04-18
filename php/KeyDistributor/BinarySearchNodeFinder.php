<?php
Namespace KeyDistributor;

class BinarySearchNodeFinder
{
  private static $nodeMap;
  private static $distributor;
  private static $nodes;

  static function setNodeMap($nodeMap)
  {
    self::$nodeMap = $nodeMap; 

    $distributor = new KeyDistributor();
    $nodes = array();

    $curMinIndex = 0;
    $numOfNodes = 0;
    foreach(self::$nodeMap as $name => $node) {
      $numOfNodes += $node['weight'];
      $node['name'] = $name; 
      $node['max_index'] = $curMinIndex + $node['weight'] - 1;
      $node['min_index'] = $curMinIndex;
      $nodes[] = $node;
      $curMinIndex += $node['weight'];       
    }

    $distributor->setNumOfNodes($numOfNodes);

    self::$distributor = $distributor;
    self::$nodes = $nodes;
  }

  static function findNodeForKey($key) 
  {
    $numOfNodes = count(self::$nodeMap);

    $virtualIndex = self::$distributor->getNodeIndexForKey($key);
    //now start binary search 
    $left = 0;
    $right = $numOfNodes;

    $searchCounter = 0;
    while(true) {
      $realIndex = (int)(($left + $right)/2);
      $searchCounter ++;
      if ( 
        ($virtualIndex <= self::$nodes[$realIndex]['max_index'] && $virtualIndex >= self::$nodes[$realIndex]['min_index']) 
      ) {
        return self::$nodes[$realIndex]['name']; 
        break;
      }  else if ($virtualIndex > self::$nodes[$realIndex]['max_index']) {
        $left = (int) (($left + $right) / 2);
      } else if ($virtualIndex < self::$nodes[$realIndex]['min_index']) {
        $right = (int) (($right + $left) / 2);
      } 
    }
  }
}
