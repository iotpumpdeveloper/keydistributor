<?php 
spl_autoload_register(function($class) {
    require (__DIR__.'/../'.str_replace('\\','/',$class).'.php');
});

$kd = new KeyDistributor\KeyDistributor();
const NUM_OF_USERS = 1000000;
$slotCounters = array();
for ($i = 0; $i < NUM_OF_USERS; $i++) {
    $playerId = 'pid_'.uuid_create();
    $slot = $kd->getSlotForKey($playerId);
    if ( !isset($slotCounters[$slot]) ) {
        $slotCounters[$slot] = 0;
    }
    $slotCounters[$slot] ++;
}

foreach($slotCounters as $slot => $counter) {
    echo "slot: $slot : ".$counter."\n";
}
