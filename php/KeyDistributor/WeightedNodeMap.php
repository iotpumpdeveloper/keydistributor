<?php
namespace KeyDistributor;

class WeightedNodeMap 
{
  private $finderClass = "ExpandedRangeNodeFinder";

  public function __construct($nodeMap)
  {
    $this->nodeMap = $nodeMap;
  }

  public function setNodeSearchAlgorithm($algorithmName)
  {
    $finderClass = $this->finderClass = __namespace__.'\\'.$algorithmName.'NodeFinder';
    $finderClass::setNodeMap($this->nodeMap); 
  }

  public function getNodeForKey($key)
  {
    $finderClass = $this->finderClass;
    return $finderClass::findNodeForKey($key);
  }
}
