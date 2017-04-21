<?php 
namespace KeyDistributor;

class ExpandedRangeNodeFinder extends NodeFinder
{
    public static function setNodeMap($nodeMap)
    {
        self::$nodeMap = $nodeMap;
        self::$distributor = new KeyDistributor();
        $actualNodes = array();
        foreach(self::$nodeMap as $name => $node) {
            for ($i = 0; $i < $node['weight']; $i++) {
                $actualNodes[] = $name;
            }
        }

        self::$distributor->setNumOfNodes(count($actualNodes));
        self::$nodes = $actualNodes;
    }

    public static function findNodeForKey($key)
    {
        $virtualIndex = self::$distributor->getNodeIndexForKey($key);
        return self::$nodes[$virtualIndex];
    }

    public static function findNodeForSlot($slot)
    {
        $virtualIndex = self::$distributor->getNodeIndexForSlot($slot);
        return self::$nodes[$virtualIndex];
    }
}
