<?php
spl_autoload_register(function($class) {
  require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$kd = new KeyDistributor\KeyDistributor();

const NUM_OF_USERS = 1000000;
$slots = array();
for ($i = 0; $i < NUM_OF_USERS; $i++) {
    $playerId = 'pid_'.uuid_create();
    $slot = $kd->getSlotForKey($playerId);
    if ( !isset($slots[$slot]) ) {
        $slots[$slot] = array();
    }
    $slots[$slot][] = $playerId;
}

foreach($slots as $slot => $slotArray) {
    $slotText = "";
    foreach($slotArray as $playerId) {
        $slotText .= $playerId."\n";
    }
    file_put_contents("/tmp/slots/slot_{$slot}_pid.txt", $slotText);
}
