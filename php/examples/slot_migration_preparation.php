<?php
spl_autoload_register(function($class) {
  require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

//first node map
$nodeMap_1 = array(
  's1' => array('weight' => 4),
  's2' => array('weight' => 16),
  's3' => array('weight' => 32)
);

//second node map, we remove s1, and add a new server s4
$nodeMap_2 = array(
  's2' => array('weight' => 16),
  's3' => array('weight' => 32),
  's4' => array('weight' => 64)
);

$slot = rand(0,16383);

$map = new KeyDistributor\WeightedNodeMap($nodeMap_1);
echo "before migration, slot $slot is at server: ".$map->getNodeForSlot($slot)."\n";

$map = new KeyDistributor\WeightedNodeMap($nodeMap_2);
echo "after migration, slot $slot will be at server: ".$map->getNodeForSlot($slot)."\n";
