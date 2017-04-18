<?php
spl_autoload_register(function($class) {
  require ('./'.str_replace('\\','/',$class).'.php');
});

$key = 'player_id_'.uuid_create();

//we use server memory as the weight, for example: 1GB is 1, 4GB is 4, 8GB is 8... etc, maximum weight: 4096GB 2^20GB
$nodes = array(
  array('name' => 's1', 'weight' => 32),
  array('name' => 's2', 'weight' => 4),
  array('name' => 's3', 'weight' => 4),
  array('name' => 's4', 'weight' => 2),
  array('name' => 's5', 'weight' => 16),
  array('name' => 's6', 'weight' => 16),
  array('name' => 's7', 'weight' => 16),
  array('name' => 's8', 'weight' => 32),
);

$kd = new KeyDistributor\WeightedKeyDistributor($nodes);
$kd->setNodeIndexSearchAlgorithm("BinarySearch");

echo $kd->getNodeForKey($key)."\n";
$kd->setNodeIndexSearchAlgorithm("");

echo $kd->getNodeForKey($key)."\n";
