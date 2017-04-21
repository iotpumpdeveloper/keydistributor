<?php 
Namespace KeyDistributor;

class KeyDistributor
{

    private const NUM_OF_SLOTS = 16384; //2^14

    private $numOfNodes;
    private $numOfSlots;

    public function __construct()
    {
        $this->numOfNodes = 0;
        $this->numOfSlots = self::NUM_OF_SLOTS;
    }

    public function setNumOfSlots($numOfSlots)
    {
        $this->numOfSlots = $numOfSlots;
    }

    public function getNumOfSlots()
    {
        return $this->getNumOfSlots;
    }

    public function setNumOfNodes($numOfNodes)
    {
        $this->numOfNodes = $numOfNodes;
    }

    public function getNumOfNodes()
    {
        return $this->numOfNodes;
    }

    public function getSlotForKey($key)
    {
        $slot = crc32($key) % $this->numOfSlots; 
        return $slot;
    }

    public function getNodeIndexForSlot($slot)
    {
        $index = $slot % $this->numOfNodes;
        return $index;
    }

    public function getNodeIndexForKey($key)
    {
        $slot = $this->getSlotForKey($key);
        return $this->getNodeIndexForSlot($slot);
    }

}
