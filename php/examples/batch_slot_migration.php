<?php 
spl_autoload_register(function($class) {
    require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

//first node map
$nodeMap_1 = array(
    's1' => array('weight' => 1),
    's2' => array('weight' => 1),
    's3' => array('weight' => 1)
);

//second node map, we remove s1, and add a new server s4
$nodeMap_2 = array(
    's2' => array('weight' => 1),
    's3' => array('weight' => 1),
    's4' => array('weight' => 1),
);

$numOfSlotsToMigrate = 0;
for ($slot = 0; $slot < 65536; $slot ++) {
    $map = new KeyDistributor\WeightedNodeMap($nodeMap_1);
    $startingNode = $map->getNodeForSlot($slot);
    $map = new KeyDistributor\WeightedNodeMap($nodeMap_2);
    $endingNode = $map->getNodeForSlot($slot);
    if ($endingNode != $startingNode) {
        $numOfSlotsToMigrate ++;
    }
}

echo "Need to migrate $numOfSlotsToMigrate slots\n";
