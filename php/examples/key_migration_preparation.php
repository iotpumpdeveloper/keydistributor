<?php
spl_autoload_register(function($class) {
  require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

//first node map
$nodeMap_1 = [];
for ($i = 1; $i <= 64; $i++) {
    $weight = rand(1,4);
    $nodeMap_1["s$i"] = ['weight' => $weight];
}

//second node map
$nodeMap_2 = [];
for ($i = 1; $i <= 32; $i++) {
    $nodeMap_2["s$i"] = $nodeMap_1["s$i"]; 
}

$key = 'player_id_'.uuid_create();

$time_start = microtime(true); 
$map = new KeyDistributor\WeightedNodeMap($nodeMap_1);
$fromNode = $map->getNodeForKey($key);

$map = new KeyDistributor\WeightedNodeMap($nodeMap_2);
$toNode = $map->getNodeForKey($key);

echo $fromNode.':'.$toNode."\n";
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start)."\n";
