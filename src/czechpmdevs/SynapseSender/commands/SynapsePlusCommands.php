<?php
namespace czechpmdevs\SynapseSender\commands;

use czechpmdevs\SynapseSender\SynapsePlus;
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
                "§7/sp kick : Kick Player from every server\n" .
                "§7/sp hub: Teleports Player to Lobby Server");
            return;
        }

        if (!$sender instanceof SPlayer){
            $sender->sendMessage("§cYou are not connected to Proxy!\n§eTry contacting Admin for help");
            return;
        }

        switch (strtolower($args[0])){
            case "lobby":
            case "hub":
                SynapsePlus::getInstance()->getApi()->gotoLobby($sender);
                break;
            case "message":
                if (!isset($args[1]) || !isset($args[2])){
                    $sender->sendMessage("§cYou must define §ePlayer§c and §eMessage§c!");
                    break;
                }
                SynapsePlus::getInstance()->getApi()->sendMessage($sender, $args[1], $args[2]);
                break;
            case "messageall":
                SynapsePlus::getInstance()->getApi()->sendMessageAll($args[1]);
                break;
            case "kick":
                SynapsePlus::getInstance()->getApi()->kick($args[1]);
                break;
        }

    }

    public function getPlugin(): Plugin{
        return $this->plugin;
    }
}
