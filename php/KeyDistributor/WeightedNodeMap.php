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
      BinarySearchNodeFinder::setNodeMap($this->nodes); 
      return BinarySearchNodeFinder::findNodeForKey($key);
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
