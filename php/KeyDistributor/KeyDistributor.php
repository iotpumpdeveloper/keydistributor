<?php 
Namespace KeyDistributor;

class KeyDistributor
{

    private const NUM_OF_SLOTS = 16384; //2^14

    private $numOfNodes;

    public function __construct()
    {
        $this->numOfNodes = 0;
    }

    public function setNumOfNodes($numOfNodes)
    {
        $this->numOfNodes = $numOfNodes;
    }

    public function getNumOfNodes()
    {
        return $this->numOfNodes;
    }

    public function getNumOfSlots()
    {
        return self::NUM_OF_SLOTS;
    }

    public function getSlotForKey($key)
    {
        $slot = crc32($key) % self::NUM_OF_SLOTS; 
        return $slot;
    }

    public function getNodeIndexForSlot($slot)
    {
        $index = $slot % $this->numOfNodes;
        return $index;
    }

    public function getNodeIndexForKey($key)
    {
        $slotsPerNode = (int)(self::NUM_OF_SLOTS / $this->numOfNodes);
        $slot = $this->getSlotForKey($key);
        return $this->getNodeIndexForSlot($slot);
    }

}
