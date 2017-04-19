<?php 
namespace KeyDistributor;

class ExpandedRangeNodeFinder
{
    private static $nodeMap;
    private static $distributor;
    private static $nodes;

    public static function setNodeMap($nodeMap)
    {
        self::$nodeMap = $nodeMap;
        $distributor = new KeyDistributor();
        $actualNodes = array();
        foreach(self::$nodeMap as $name => $node) {
            for ($i = 0; $i < $node['weight']; $i++) {
                $actualNodes[] = $name;
            }
        }

        $distributor->setNumOfNodes(count($actualNodes));
        self::$distributor = $distributor;
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
