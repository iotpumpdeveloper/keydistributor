<?php 
spl_autoload_register(function($class) {
    require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$nodeMap = [
    ['weight' => 2],
    ['weight' => 2],
    ['weight' => 2],
    ['weight' => 2],
    ['weight' => 2]
];

$map = new KeyDistributor\WeightedNodeMap($nodeMap);
$map->syncSlotWithNodes();

$node = $map->getNodeForKey(uuid_create());

print $node."\n";
