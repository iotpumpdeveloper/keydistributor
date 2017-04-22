<?php 
namespace KeyDistributor;

class NodeFinder 
{
    protected $nodeMap;
    protected $distributor;
    protected $nodes;

    public function syncSlotWithNodes()
    {
        $this->distributor->setNumOfSlots(count($this->nodes));
    }
}
