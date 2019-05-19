<?php
namespace czechpmdevs\SynapseSender\Untils;

use pocketmine\utils\TextFormat;

class Text{

    public static function format(string $msg){
        $msg = str_replace("§", "&", $msg);
        return $msg;
    }
}