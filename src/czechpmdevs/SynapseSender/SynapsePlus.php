<?php

namespace czechpmdevs\SynapseSender;


use czechpmdevs\SynapseSender\commands\SynapsePlusCommands;
use czechpmdevs\SynapseSender\Untils\SynapseSender;
use czechpmdevs\SynapseSender\Untils\Text;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use synapsepm\network\protocol\spp\PluginMessagePacket;
use synapsepm\SynapsePM;

class SynapsePlus extends PluginBase implements Listener{
    /** @var Config */
    public $cfg;

    /**
     * @var Command[] $commands
     */
    private $commands = [];

    private $API;
    private static $instance;
    
    public function onEnable(){
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
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		switch($command->getName()){
			case "info":
			    /** @var SynapsePM */
			    $synapsePM = $this->getServer()->getPluginManager()->getPlugin('SynapsePM');
                //$synapsePM = new SynapsePM();
               $synapses = $synapsePM->getSynapses();

               $message = "SkyWars:Alemiz112,alemiz003";

               foreach ($synapses as $synapse){
                   $pk = new PluginMessagePacket();
                   $pk->channel = "ServerPM";
                   $pk->data = $message;
                   $synapse->sendDataPacket($pk);
               }
                $this->getLogger()->info("Packet Sent");


                return true;
		}
	}
    public function onDisable() {
        $this->getLogger()->info("Plugin has been dissabled!");
    }
}

