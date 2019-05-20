<?php
namespace czechpmdevs\synapseplus\utils;

use pocketmine\utils\TextFormat;

class Text{

    public static function format(string $msg){
        $msg = str_replace("§", "&", $msg);
        return $msg;
    }
}