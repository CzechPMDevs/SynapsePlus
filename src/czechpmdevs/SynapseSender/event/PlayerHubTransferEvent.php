<?php

namespace czechpmdevs\SynapseSender\event;

use czechpmdevs\SynapseSender\Untils\SynapseSender;
use synapsepm\event\Event;

class PlayerHubTransferEvent extends Event{

    /** @var null $handlerList */
    public static $handlerList = null;

    protected $lobby;

    protected $synapseServer;

    public function __construct(SynapseSender $synapseSender, string $lobby){
        $this->synapseServer = $synapseSender;
        $this->lobby = $lobby;
    }

    /**
     * @return string
     */
    public function getLobby(){
        return $this->lobby;
    }
}
