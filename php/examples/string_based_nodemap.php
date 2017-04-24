<?php
spl_autoload_register(function($class) {
  require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$mapString1 = "1.1.2.4.1.2.1";
$mapString2 = "1.1.2.4.1.0.3"; //"delete" server 5, add server 5's weight to the adjacent server's weight
$map1 = new KeyDistributor\WeightedNodeMap($mapString1);
$map2 = new KeyDistributor\WeightedNodeMap($mapString2);

//now generate 1000 keys 
$numOfKeysToMigrate = 0;
for ($i = 1; $i <= 2000; $i++) {
    $key = uuid_create();
    $fromNode = $map1->getNodeForKey($key);
    $toNode = $map2->getNodeForKey($key);

    if ($fromNode != $toNode) {
        $numOfKeysToMigrate ++;
    }
}

echo "Need to migrate $numOfKeysToMigrate keys\n";
