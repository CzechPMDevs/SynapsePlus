<?php
namespace czechpmdevs\SynapseSender\Untils;

use czechpmdevs\SynapseSender\event\PlayerChangeServerEvent;
use czechpmdevs\SynapseSender\event\PlayerHubTransferEvent;
use czechpmdevs\SynapseSender\StaffManager\Manager;
use czechpmdevs\SynapseSender\SynapsePlus;
use pocketmine\block\Thin;
use pocketmine\item\Item;
use synapsepm\Player;
use synapsepm\Synapse;
use synapsepm\Player as SPlayer;



class SynapseSender{

    public $synapsePlus;

    public $synapses;

    /** @var Manager */
    private $staffManager;

    private static $instance;

    public function __construct(SynapsePlus $synapsePlus){
        $this->synapsePlus = $synapsePlus;
        $this->staffManager = new Manager($this);

        $this->reloadSynapses();
        self::$instance = $this;
    }

    /** @return SynapseSender */
    public static function getInstance(){
        return self::$instance;
    }


    //For feature uses, to get all connections to Nemisys
    public function reloadSynapses(){
        $synapsePM = $this->synapsePlus->getServer()->getPluginManager()->getPlugin('SynapsePM');
        $this->synapses = $synapsePM->getSynapses();
    }

    /**
     * @return array
     */
    public function getSynapses(){
        return $this->synapses;
    }

    /** @return Manager */
    public function getStaffManager(){
        return $this->staffManager;
    }

    //Begin of Main Functions

    /**
     * @param SPlayer $player
     * @throws \ReflectionException
     */
    public function gotoLobby(SPlayer $player){
        $lobby = $this->synapsePlus->cfg->get("LobbyServers");
        $lobby = $lobby[rand(0, count($lobby))];
        $player->synapseTransferByDesc($lobby);

        $event = new PlayerHubTransferEvent($this, $lobby);
        $event->call();
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

