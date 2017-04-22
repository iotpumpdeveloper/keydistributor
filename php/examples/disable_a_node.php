<?php 
spl_autoload_register(function($class) {
    require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

//we can simply disable a node by setting its weight to 0

$nodeMap1 = [
    's1' => ['weight' => 2],
    's2' => ['weight' => 2],
    's3' => ['weight' => 2],
    's4' => ['weight' => 2],
    's5' => ['weight' => 2]
];

//now remove s2  
$nodeMap2 = [
    's1' => ['weight' => 2],
    's3' => ['weight' => 0],
    's4' => ['weight' => 8]
];

$map1 = new KeyDistributor\WeightedNodeMap($nodeMap1);
$map1->syncSlotWithNodes();
$map2 = new KeyDistributor\WeightedNodeMap($nodeMap2);
$map2->syncSlotWithNodes();

$migrationCounter_s1 = 0;
$migrationCounter_s3 = 0;
$migrationCounter_s4 = 0;
for ($j = 0; $j < 20000; $j++) {
    $key = uuid_create();
    $fromNode = $map1->getNodeForKey($key);
    $toNode = $map2->getNodeForKey($key);
    if ($toNode != $fromNode && $toNode == 's1') {
        $migrationCounter_s1 ++;   
    } else if ($toNode != $fromNode && $toNode == 's3') {
        $migrationCounter_s3 ++;
    } else if ($toNode != $fromNode && $toNode == 's4') {
        $migrationCounter_s4 ++;
    }
}

echo "keys migrated to s1 : ".$migrationCounter_s1."\n";
echo "keys migrated to s3 : ".$migrationCounter_s3."\n";
echo "keys migrated to s4 : ".$migrationCounter_s4."\n";
