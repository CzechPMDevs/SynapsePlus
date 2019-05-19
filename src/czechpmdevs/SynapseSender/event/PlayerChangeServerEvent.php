<?php
namespace czechpmdevs\SynapseSender\event;

use czechpmdevs\SynapseSender\Untils\SynapseSender;
use pocketmine\event\Event;
use pocketmine\Player;

class PlayerChangeServerEvent extends  Event{

    /** @var null $handlerList */
    public static $handlerList = null;

    /** @var Player */
    protected $player;

    public function __construct(SynapseSender $sender, Player $player){
        $this->player = $player;
    }

    public function getPlayer(){
        return $this->player;
    }
}
