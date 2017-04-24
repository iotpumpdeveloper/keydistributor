<?php
namespace KeyDistributor;

class WeightedNodeMap 
{
    private $finder;

    public function __construct($nodeMap)
    {
        /**
         * new feature, allow string based node map, example:
         * 1.1.2.3.4.5.2.3
         */

        if (is_string($nodeMap)) {
            $comps = explode(".", $nodeMap);
            $_nodeMap = [];
            foreach($comps as $nodeName => $weight) {
                $_nodeMap[$nodeName] = ['weight' => $weight]; 
            }

            $nodeMap = $_nodeMap;
        }

        $this->nodeMap = $nodeMap;
        $this->setNodeSearchAlgorithm("ExpandedRange"); 
    }

    public function getMap()
    {
        return $this->nodeMap;
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
