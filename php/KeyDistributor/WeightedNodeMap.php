<?php
namespace KeyDistributor;

class WeightedNodeMap 
{
    private $finder;

    public function __construct($nodeMap)
    {
        $this->nodeMap = $nodeMap;
        $this->setNodeSearchAlgorithm("ExpandedRange"); 
    }

    public function setNodeSearchAlgorithm($algorithmName)
    {
        $finderClass = $this->finderClass = __namespace__.'\\'.$algorithmName.'NodeFinder';
        $this->finder = new $finderClass();
        $this->finder->setNodeMap($this->nodeMap);
    }

    public function syncSlotWithNodes()
    {
        $this->finder->syncSlotWithNodes();
    }

    public function getNodeForKey($key)
    {
        return $this->finder->findNodeForKey($key);
    }

    public function getNodeForSlot($slot)
    {
        return $this->finder->findNodeForSlot($slot);
    }
}
