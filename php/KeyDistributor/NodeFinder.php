<?php 
namespace KeyDistributor;

class NodeFinder 
{
    protected static $nodeMap;
    protected static $distributor;
    protected static $nodes;

    public static function syncSlotWithNodes()
    {
        self::$distributor->setNumOfSlots(count(self::$nodes));
    }

}
