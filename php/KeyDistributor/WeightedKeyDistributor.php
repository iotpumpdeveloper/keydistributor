<?php
namespace KeyDistributor;

class WeightedKeyDistributor extends KeyDistributor 
{
  public function __construct($nodes)
  {
    $actualNodes = array();
    foreach($nodes as $node) {
      $arr = array_fill(0, $node['weight'], $node['name']);
      $actualNodes = array_merge($actualNodes, $arr);
    }

    $this->nodes = $actualNodes;

    $this->setNumOfNodes(count($actualNodes));
  }

  public function getNodeForKey($key)
  {
    $index = $this->getNodeIndexForKey($key);
    return $this->nodes[$index];
  }
}
