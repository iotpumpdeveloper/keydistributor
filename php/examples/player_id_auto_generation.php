<?php
spl_autoload_register(function($class) {
  require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$kd = new KeyDistributor\KeyDistributor();

const NUM_OF_USERS = 1000000;
$playerIdTxt = "";
for ($i = 0; $i < NUM_OF_USERS; $i++) {
    $playerId = 'pid_'.uuid_create();
    $slot = $kd->getSlotForKey($playerId);
    $entry = $playerId.":".$slot."\n";
    $playerIdTxt .= $entry;
}
file_put_contents("player_ids.txt", $playerIdTxt);
