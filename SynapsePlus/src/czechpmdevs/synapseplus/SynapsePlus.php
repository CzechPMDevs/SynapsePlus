<?php

namespace czechpmdevs\synapseplus;

use czechpmdevs\synapseplus\commands\SynapsePlusCommands;
use czechpmdevs\synapseplus\staffmanager\StaffManager;
use czechpmdevs\synapseplus\utils\SynapseSender;
use czechpmdevs\synapseplus\utils\Text;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use synapsepm\network\protocol\spp\PluginMessagePacket;
use synapsepm\SynapsePM;
use synapsepm\Player as SPlayer;

class SynapsePlus extends PluginBase implements Listener {

    /** @var Config */
    public $cfg;

    /** @var Command[] $commands */
    private $commands = [];

    private $API;
    private static $instance;

    public function onEnable() {
        new SynapsePMUpdater($this);
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->cfg = $this->getConfig();

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->register("SynapsePlus", $this->commands[] = new SynapsePlusCommands($this));

        $this->API = new SynapseSender($this);
        self::$instance = $this;

        new Text();
    }

    /**
     * @return SynapseSender
     */
    public function getApi(){
        return $this->API;
    }

    /**
     * @return SynapsePlus
     */
    public static function getInstance(){
        return self::$instance;
    }

    //TODO: Maybe separated listener ??
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if (!$player instanceof SPlayer) return;
        if ($player->hasPermission("sp.plus.staff")){
            StaffManager::getInstance()->addStaff($player);
        }
    }

    public function onQuit(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        if (!$player instanceof SPlayer) return;
        if ($player->hasPermission("sp.plus.staff")){
            StaffManager::getInstance()->removeStaff($player);
        }
    }
}

