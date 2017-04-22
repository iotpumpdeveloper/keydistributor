<?php 
spl_autoload_register(function($class) {
    require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$nodeMap1 = [
    's1' => ['weight' => 2],
    's2' => ['weight' => 2],
    's3' => ['weight' => 2],
    's4' => ['weight' => 2]
];

//now remove s2 and evently distribute s2's weight on s3 and s4 
$nodeMap2 = [
    's1' => ['weight' => 2],
    's3' => ['weight' => 3],
    's4' => ['weight' => 3]
];

$map1 = new KeyDistributor\WeightedNodeMap($nodeMap1);
$map1->syncSlotWithNodes();
$map2 = new KeyDistributor\WeightedNodeMap($nodeMap2);
$map2->syncSlotWithNodes();

$migrationCounter_s3 = 0;
$migrationCounter_s4 = 0;
$counter = 0;
for ($j = 0; $j < 20000; $j++) {
    $key = $counter ++;
    $fromNode = $map1->getNodeForKey($key);
    $toNode = $map2->getNodeForKey($key);
    if ($toNode != $fromNode && $toNode == 's3') {
        $migrationCounter_s3 ++;
    } else if ($toNode != $fromNode && $toNode == 's4') {
        $migrationCounter_s4 ++;
    }
}

echo "keys migrated to s3 : ".$migrationCounter_s3."\n";
echo "keys migrated to s4 : ".$migrationCounter_s4."\n";
