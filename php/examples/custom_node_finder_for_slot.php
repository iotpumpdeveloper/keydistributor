<?php
spl_autoload_register(function($class) {
  require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$slot = rand(0,65535);
echo "slot: ".$slot."\n";
//we use server memory as the weight, for example: 1GB is 1, 4GB is 4, 8GB is 8... etc

$nodeMap = array();

for ($i = 1; $i <= 100; $i++) {
  $name = 's'.$i;
  $nodeMap[$name] = array('weight' => 32);
}

$map = new KeyDistributor\WeightedNodeMap($nodeMap);

$map->setNodeSearchAlgorithm("BinarySearch");
$time_start = microtime(true); 
echo $map->getNodeForSlot($slot)."\n";
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start)."\n";
$map->setNodeSearchAlgorithm("ExpandedRange");

$time_start = microtime(true); 
echo $map->getNodeForSlot($slot)."\n";
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start)."\n";
