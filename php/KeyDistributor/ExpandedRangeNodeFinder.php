<?php 
namespace KeyDistributor;

class ExpandedRangeNodeFinder
{
  private static $nodeMap;
  private static $distributor;
  private static $nodes;

  public static function setNodeMap($nodeMap)
  {
    self::$nodeMap = $nodeMap;
    $distributor = new KeyDistributor();
    $actualNodes = array();
    foreach(self::$nodeMap as $name => $node) {
      $arr = array_fill(0, $node['weight'], $name);
      $actualNodes = array_merge($actualNodes, $arr);
    }
   
    $distributor->setNumOfNodes(count($actualNodes));
    self::$distributor = $distributor;
    self::$nodes = $actualNodes;
  }

  public static function findNodeForKey($key)
  {
    $virtualIndex = self::$distributor->getNodeIndexForKey($key);
    return self::$nodes[$virtualIndex];
  }
}
