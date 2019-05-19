<?php
namespace czechpmdevs\SynapseSender\Untils;

use czechpmdevs\SynapseSender\event\PlayerChangeServerEvent;
use czechpmdevs\SynapseSender\SynapsePlus;
use pocketmine\block\Thin;
use pocketmine\item\Item;
use synapsepm\Player;
use synapsepm\Synapse;
use synapsepm\Player as SPlayer;



class SynapseSender{

    public $synapsePlus;

    public $synapses;

    public function __construct(SynapsePlus $synapsePlus){
        $this->synapsePlus = $synapsePlus;

        $this->reloadSynapses();
    }


    //For feature uses, to get all connections to Nemisys
    public function reloadSynapses(){
        $synapsePM = $this->synapsePlus->getServer()->getPluginManager()->getPlugin('SynapsePM');
        $this->synapses = $synapsePM->getSynapses();
    }

    /**
     * @return mixed
     */
    public function getSynapses(){
        return $this->synapses;
    }

    //Begin of Main Functions

    /**
     * @param SPlayer $player
     */
    public function gotoLobby(SPlayer $player){
        $lobby = $this->synapsePlus->cfg->get("LobbyServers");
        $lobby = $lobby[rand(0, count($lobby))];
        $player->synapseTransferByDesc($lobby);
    }

    /**
     * @param SPlayer $player
     * @param $receiver
     * @param $message
     */
    public function sendMessage(SPlayer $player, $receiver, $message){
        $message = Text::format($message);
        $player->getSynapse()->sendPluginMessage("Message", "{$receiver}:{$message}");
    }

    /**
     * @param string $message
     */
    public function sendMessageAll(string $message){
        foreach ($this->synapses as $synapse){
            /** @var $synapse Synapse */
            $synapse->sendPluginMessage("MessageAll", Text::format($message));
        }
    }


    /**
     * @param $player
     */
    public function kick($player){
        if ($player instanceof Player) $player = $player->getName();

        foreach ($this->synapses as $synapse){
            /** @var $synapse Synapse */
            $synapse->sendPluginMessage("Kick", $player);
        }
    }
}

