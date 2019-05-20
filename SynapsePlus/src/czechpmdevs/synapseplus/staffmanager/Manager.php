<?php

namespace czechpmdevs\synapseplus\staffmanager;

use czechpmdevs\synapseplus\utils\SynapseSender;
use synapsepm\Player as SPlayer;

class Manager{

    /** @var SynapseSender  */
    protected $synapseServer;


    public function __construct(SynapseSender $synapseSender){
        $this->synapseServer = $synapseSender;
    }

    /**
     * @param SPlayer $player
     */
    public function addStaff(SPlayer $player){
        $player->getSynapse()->sendPluginMessage("Staff", "Status_Join");
    }

    /**
     * @param SPlayer $player
     */
    public function removeStaff(SPlayer $player){
        $player->getSynapse()->sendPluginMessage("Staff", "Status_Leave");
    }

    public function sendMessage(SPlayer $player, string $message){

    }


}

