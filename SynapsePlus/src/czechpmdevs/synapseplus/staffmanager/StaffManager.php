<?php

namespace czechpmdevs\synapseplus\staffmanager;

use czechpmdevs\synapseplus\utils\SynapseSender;
use synapsepm\Player as SPlayer;
use synapsepm\Player;

class StaffManager{

    /** @var SynapseSender  */
    protected $synapseServer;

    private static $instance;

    /** @var Player[] */
    public $staffChatters = [];

    public function __construct(SynapseSender $synapseSender){
        $this->synapseServer = $synapseSender;
        self::$instance = $this;
    }

    /**
     * @return StaffManager
     */
    public static function getInstance(){
        return self::$instance;
    }

    /**
     * @param SPlayer $player
     */
    public function addStaff(SPlayer $player){
        $name = $player->getName();
        $player->getSynapse()->sendPluginMessage("Staff", "Player_LOGIN:{$name}");
    }

    /**
     * @param SPlayer $player
     */
    public function removeStaff(SPlayer $player){
        $name = $player->getName();
        $player->getSynapse()->sendPluginMessage("Staff", "Player_LOGOUT{$name}");
    }

    public function sendMessage(SPlayer $player, string $message){
    }

    /**
     * @param Player $player
     */
    public function addChatter(SPlayer $player){
        $name = $player->getName();
        $player->getSynapse()->sendPluginMessage("Staff", "Status_Join:{$name}");
    }

    /**
     * @param Player $player
     */
    public function removeChatter(SPlayer $player){
        $name = $player->getName();
        $player->getSynapse()->sendPluginMessage("Staff", "Status_Leave:{$name}");
    }


}

