<?php
Namespace KeyDistributor;

class BinarySearchNodeFinder extends NodeFinder
{
    public function setNodeMap($nodeMap)
    {
        $this->nodeMap = $nodeMap; 

        $this->distributor = new KeyDistributor();
        $nodes = array();

        $curMinIndex = 0;
        $numOfNodes = 0;
        foreach($this->nodeMap as $name => $node) {
            $numOfNodes += $node['weight'];
            $node['name'] = $name; 
            $node['max_index'] = $curMinIndex + $node['weight'] - 1;
            $node['min_index'] = $curMinIndex;
            $nodes[] = $node;
            $curMinIndex += $node['weight'];       
        }

        $this->distributor->setNumOfNodes($numOfNodes);
        $this->nodes = $nodes;
    }
 
    public function findNodeForKey($key) 
    {
        $slot = $this->distributor->getSlotForKey($key);
        return $this->findNodeForSlot($slot); 
    }

    public function findNodeForSlot($slot)
    {
        $numOfNodes = count($this->nodeMap);

        $virtualIndex = $this->distributor->getNodeIndexForSlot($slot);
        //now start binary search 
        $left = 0;
        $right = $numOfNodes;

        $searchCounter = 0;
        while(true) {
            $realIndex = (int)(($left + $right)/2);
            $searchCounter ++;
            if ( 
                ($virtualIndex <= $this->nodes[$realIndex]['max_index'] && $virtualIndex >= $this->nodes[$realIndex]['min_index']) 
            ) {
                return $this->nodes[$realIndex]['name']; 
                break;
            }  else if ($virtualIndex > $this->nodes[$realIndex]['max_index']) {
                $left = (int) (($left + $right) / 2);
            } else if ($virtualIndex < $this->nodes[$realIndex]['min_index']) {
                $right = (int) (($right + $left) / 2);
            } 
        }
    } 
}
