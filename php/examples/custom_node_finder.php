<?php
spl_autoload_register(function($class) {
  require ('./'.str_replace('\\','/',$class).'.php');
});

$key = 'player_id_'.uuid_create();

//we use server memory as the weight, for example: 1GB is 1, 4GB is 4, 8GB is 8... etc

$nodeMap = array();

for ($i = 1; $i <= 1000; $i++) {
  $name = 's'.$i;
  $nodeMap[$name] = array('weight' => 32);
}

$map = new KeyDistributor\WeightedNodeMap($nodeMap);

$map->setNodeSearchAlgorithm("BinarySearch");
$time_start = microtime(true); 
echo $map->getNodeForKey($key)."\n";
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start)."\n";
$map->setNodeSearchAlgorithm("ExpandedRange");

$time_start = microtime(true); 
echo $map->getNodeForKey($key)."\n";
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start)."\n";
