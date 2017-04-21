<?php 
spl_autoload_register(function($class) {
    require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$nodeMap_1 = array(
    's1' => array('weight' => 16),
    's2' => array('weight' => 16),
    's3' => array('weight' => 16)
);

$nodeMap_2 = array();
$nodeMap_2['s2']['weight'] = 48;

$key = 'player_id_'.uuid_create();

$map = new KeyDistributor\WeightedNodeMap($nodeMap_1);
$map->syncSlotWithNodes();

$fromNode = $map->getNodeForKey($key);

$map = new KeyDistributor\WeightedNodeMap($nodeMap_2);
$map->syncSlotWithNodes();
$toNode = $map->getNodeForKey($key);

echo $fromNode.":".$toNode."\n";
