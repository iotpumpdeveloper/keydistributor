<?php
spl_autoload_register(function($class) {
  require ('./'.str_replace('\\','/',$class).'.php');
});

$key = 'player_id_'.uuid_create();

//we use server memory as the weight, for example: 1GB is 1, 4GB is 4, 8GB is 8... etc
$nodes = array(
  's1' => array('weight' => 32),
  's2' => array('weight' => 32),
  's3' => array('weight' => 32),
  's4' => array('weight' => 32),
);

$map = new KeyDistributor\WeightedNodeMap($nodes);
$map->setNodeSearchAlgorithm("BinarySearch");

echo $map->getNodeForKey($key)."\n";
$map->setNodeSearchAlgorithm("");

echo $map->getNodeForKey($key)."\n";
