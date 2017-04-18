<?php 
Namespace KeyDistributor;

class KeyDistributor
{

  private const NUM_OF_SLOTS = 4294967296; //2^16

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

  public function getNodeIndexForKey($key)
  {
    $slotsPerNode = (int)(self::NUM_OF_SLOTS / $this->numOfNodes);
    $slot = crc32($key) % self::NUM_OF_SLOTS;
    $index = (int) ($slot / $slotsPerNode);
    return $index;
  }

}
