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
  }

  public function getNodeForKey($key)
  {
    if ($this->nodeSearchAlgorithm == "BinarySearch") {
      BinarySearchNodeFinder::setNodeMap($this->nodes); 
      return BinarySearchNodeFinder::findNodeForKey($key);
    } else {
      ExpandedRangeNodeFinder::setNodeMap($this->nodes);
      return ExpandedRangeNodeFinder::findNodeForKey($key);
    }

  }
}
