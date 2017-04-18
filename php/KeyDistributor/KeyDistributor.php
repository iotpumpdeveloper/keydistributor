<?php 
Namespace KeyDistributor;

class KeyDistributor
{

  private const NUM_OF_SLOTS = 4294967296; //2^32

  private $numOfNodes;

  private function _getNodeIndexForKey($key, $numOfNodes)
  {
    $slotsPerNode = (int)(self::NUM_OF_SLOTS / $numOfNodes);
    $slot = $this->getSlotForKey($key);
    $index = (int) ($slot / $slotsPerNode);
    return $index;
  }

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

  public function getSlotForKey($key)
  {
    $slot = crc32($key) % self::NUM_OF_SLOTS;
    return $slot; 
  }

  public function getNodeIndexForKey($key)
  {
    $index = $this->_getNodeIndexForKey($key, $this->numOfNodes);
    return $index;
  }

  public function getMigrationPathForKey($key)
  {
    $indexes = array();
    for ($i = 1; $i <= $this->numOfNodes; $i++) {
      $indexes[] = $this->_getNodeIndexForKey($key, $i); 
    }
    return implode(".", $indexes);
  }
}
