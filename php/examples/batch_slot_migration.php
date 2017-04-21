<?php 
spl_autoload_register(function($class) {
    require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

//first node map, in the day time we have more traffic, we have more servers
$nodeMap_1 = array(
    's1' => array('weight' => 32),
    's2' => array('weight' => 16),
    's3' => array('weight' => 4),
    's4' => array('weight' => 4),
    's5' => array('weight' => 4),
    's6' => array('weight' => 4),
    's7' => array('weight' => 2),
    's8' => array('weight' => 2),
);

//second node map, in the night time, we have much less traffic, we remove some servers 
$nodeMap_2 = array(
    's1' => array('weight' => 32)
);

$numOfSlotsToMigrate = 0;
for ($slot = 0; $slot < 16383; $slot ++) {
    $map = new KeyDistributor\WeightedNodeMap($nodeMap_1);
    $startingNode = $map->getNodeForSlot($slot);
    $map = new KeyDistributor\WeightedNodeMap($nodeMap_2);
    $endingNode = $map->getNodeForSlot($slot);
    if ($endingNode != $startingNode) {
        $numOfSlotsToMigrate ++;
    }
}

echo "Need to migrate $numOfSlotsToMigrate slots\n";
