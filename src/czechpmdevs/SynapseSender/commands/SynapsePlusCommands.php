<?php
namespace czechpmdevs\SynapseSender\commands;

use czechpmdevs\SynapseSender\SynapsePlus;
use czechpmdevs\SynapseSender\Untils\SynapseSender;
use czechpmdevs\SynapseSender\Untils\Text;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use synapsepm\Player as SPlayer;


class SynapsePlusCommands extends Command implements PluginIdentifiableCommand{

    private $plugin;

    /**
     * SynapsePlusCommands constructor.
     * @param SynapsePlus $plugin
     */
    public function __construct(SynapsePlus $plugin){
        $this->plugin = $plugin;

        parent::__construct("SynapsePlus", "SynapsePlus Commands...", null, ["sp", "synapse"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if (!isset($args[0])){
            $sender->sendMessage("§f» §6SynapsePlus commands: §f«\n" .
                "§7/sp message <player> <message> : Send Message to Player\n".
                "§7/sp messageall <message>: Send Message for all Players\n".
                "§7/sp kick : Kick Player from every Server\n" .
                "§7/sp hub: Teleports Player to Lobby Server".
                "§7/sp staff: Staff Chat");
            return;
        }

        if (!$sender instanceof SPlayer){
            $sender->sendMessage("§cYou are not connected to Proxy!\n§eTry contacting Admin for help");
            return;
        }

        switch (strtolower($args[0])){
            case "lobby":
            case "hub":
                SynapseSender::getInstance()->gotoLobby($sender);
                break;
            case "message":
                if (!isset($args[1]) || !isset($args[2])){
                    $sender->sendMessage("§cYou must define §ePlayer§c and §eMessage§c!");
                    break;
                }
                SynapseSender::getInstance()->sendMessage($sender, $args[1], $args[2]);
                break;
            case "messageall":
                if (!isset($args[1])){
                    $sender->sendMessage("§cYou must define Message!");
                }
                SynapseSender::getInstance()->sendMessageAll($args[1]);
                break;
            case "kick":
                if (!isset($args[1])){
                    $sender->sendMessage("§cYou must define Payer Name!");
                }
                SynapseSender::getInstance()->kick($args[1]);
                break;

            case "staff":
                if (!isset($args[1])){
                    $sender->sendMessage("§6Usage: \n§7/staff <on|off> For staff chat only\n" .
                                         "§7/staff <message> For single message");
                    break;
                }
                if ($args[1] == "on" or "off"){
                    
                }
        }

    }

    public function getPlugin(): Plugin{
        return $this->plugin;
    }
}
