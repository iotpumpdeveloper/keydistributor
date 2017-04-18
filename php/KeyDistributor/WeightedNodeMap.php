<?php
namespace KeyDistributor;

class WeightedNodeMap 
{
  public function __construct($nodeMap)
  {
    $this->nodeMap = $nodeMap;
    $this->setNodeSearchAlgorithm("ExpandedRange"); 
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
