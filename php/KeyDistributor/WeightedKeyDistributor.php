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

      print $virtualIndex."\n";
      //now start binary search 
      $left = 0;
      $right = $numOfNodes;

      $realIndex = 0;

      while(true) {
        if ( 
          ($virtualIndex <= $this->nodes[$realIndex]['max_index'] && $virtualIndex >= $this->nodes[$realIndex]['min_index']) 
        ) {
          print_r($this->nodes[$realIndex]); 
          break;
        }  else if ($virtualIndex > $this->nodes[$realIndex]['max_index']) {
          $realIndex = (int) (($realIndex + $right) / 2);
          print "case 1\n";
          print "virtualIndex:".$virtualIndex."\n";
          print_r($this->nodes[$realIndex])."\n";
          print $realIndex."---\n";
        } else if ($virtualIndex < $this->nodes[$realIndex]['min_index']) {
          print "case 2\n";
          print "virtualIndex:".$virtualIndex."\n";
          print_r($this->nodes[$realIndex])."\n";
          print $realIndex."---\n";
          $realIndex = (int) (($realIndex + $left) / 2);
        } 
      }

    } else {
      if (!isset($this->algorithmPreparationDone)) {
        $this->algorithmPreparationDone = true;
        
        $actualNodes = array();
        foreach($this->nodes as $node) {
          $arr = array_fill(0, $node['weight'], $node['name']);
          $actualNodes = array_merge($actualNodes, $arr);
        }
        $this->setNumOfNodes(count($this->actualNodes));
      } 

      $index = $this->getNodeIndexForKey($key);
      return $actualNodes[$index];

    }

  }
}
