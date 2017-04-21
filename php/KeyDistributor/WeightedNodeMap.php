<?php
namespace KeyDistributor;

class WeightedNodeMap 
{
    private $finderClass;

    public function __construct($nodeMap)
    {
        $this->nodeMap = $nodeMap;
        $this->setNodeSearchAlgorithm("ExpandedRange"); 
    }

    public function setNodeSearchAlgorithm($algorithmName)
    {
        $finderClass = $this->finderClass = __namespace__.'\\'.$algorithmName.'NodeFinder';
        $finderClass::setNodeMap($this->nodeMap); 
        $this->finderClass = $finderClass;
    }

    public function syncSlotWithNodes()
    {
        $finderClass = $this->finderClass;
        $finderClass::syncSlotWithNodes();
    }

    public function getNodeForKey($key)
    {
        $finderClass = $this->finderClass;
        return $finderClass::findNodeForKey($key);
    }

    public function getNodeForSlot($slot)
    {
        $finderClass = $this->finderClass;
        return $finderClass::findNodeForSlot($slot);
    }
}
