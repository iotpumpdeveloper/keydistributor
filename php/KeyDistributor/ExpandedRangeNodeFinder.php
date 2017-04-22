<?php 
namespace KeyDistributor;

class ExpandedRangeNodeFinder extends NodeFinder
{
    public function setNodeMap($nodeMap)
    {
        $this->nodeMap = $nodeMap;
        $this->distributor = new KeyDistributor();
        $actualNodes = array();
        foreach($this->nodeMap as $name => $node) {
            for ($i = 0; $i < $node['weight']; $i++) {
                $actualNodes[] = $name;
            }
        }

        $this->distributor->setNumOfNodes(count($actualNodes));
        $this->nodes = $actualNodes;
    }

    public function findNodeForKey($key)
    {
        $virtualIndex = $this->distributor->getNodeIndexForKey($key);
        return $this->nodes[$virtualIndex];
    }

    public function findNodeForSlot($slot)
    {
        $virtualIndex = $this->distributor->getNodeIndexForSlot($slot);
        return $this->nodes[$virtualIndex];
    }
}
