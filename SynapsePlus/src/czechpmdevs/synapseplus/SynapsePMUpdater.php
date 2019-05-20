<?php

declare(strict_types=1);

namespace czechpmdevs\synapseplus;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

/**
 * Class SynapsePMUpdater
 * @package czechpmdevs\synapseplus
 */
class SynapsePMUpdater {

    public const LAST_PUBLISHED_VERSION = "58198_10"; // build id _ plugin build id

    /** @var SynapsePlus $plugin */
    public $plugin;

    /**
     * SynapsePMUpdater constructor.
     * @param SynapsePlus $plugin
     */
    public function __construct(SynapsePlus $plugin) {
        $this->plugin = $plugin;
        $this->load();
    }

    public function load() {
        if(!$this->plugin->getServer()->getPluginManager()->getPlugin("SynapsePM") instanceof PluginBase) {
            $this->installPlugin();
            return;
        }
        $this->checkUpdate();
    }

    public function checkUpdate() {
        if(is_dir($this->plugin->getDataFolder()) && is_file($this->plugin->getDataFolder() . DIRECTORY_SEPARATOR . "config.yml")) {
            if(($synapseVer = ($config = new Config($this->plugin->getDataFolder() . DIRECTORY_SEPARATOR . "config.yml", Config::YAML))->get("SynapseVersion")) !== self::LAST_PUBLISHED_VERSION) {
                $config->set("SynapseVersion", self::LAST_PUBLISHED_VERSION);
                $config->save();
                $this->reinstallPlugin();
            }
        }
    }

    public function reinstallPlugin() {
        $this->plugin->getLogger()->info("Reinstalling SynapsePM plugin...");
        $this->removePlugin();
        $this->installPlugin();
    }

    public function installPlugin() {
        $startTime = microtime(true);
        $linkParts = explode("_", self::LAST_PUBLISHED_VERSION);
        foreach ($linkParts as $i => $part) {
            $linkParts[$i] = trim($part);
        }

        $downloadLink = "https://poggit.pmmp.io/r/$linkParts[0]/SynapsePM_dev-$linkParts[1].phar";
        $pluginPath = $this->plugin->getServer()->getDataPath() . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "SynapsePM.phar";

        file_put_contents($pluginPath, file_get_contents($downloadLink));
        $this->plugin->getServer()->getPluginManager()->loadPlugin($this->plugin->getServer()->getDataPath() . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "SynapsePM.phar");
        $this->plugin->getServer()->getPluginManager()->enablePlugin($this->plugin->getServer()->getPluginManager()->getPlugin("SynapsePM"));
        $this->plugin->getLogger()->info("SynapsePM plugin installed (".(string)round(microtime(true)-$startTime, 2)." sec)!");
    }

    public function removePlugin() {
        $plugin = $this->plugin->getServer()->getPluginManager()->getPlugin("SynapsePM");
        if(!$plugin instanceof PluginBase) {
            $this->plugin->getLogger()->error("Could not remove SynapsePM plugin - plugin not found.");
            return;
        }
        $this->plugin->getServer()->getPluginManager()->disablePlugin($plugin);
        $plugins = glob($plugin->getServer()->getDataPath() . DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "*.phar");

        // plugin can have name with build number
        foreach ($plugins as $pl) {
            if(str_replace(strtolower($pl), "synapsepm", "") != $pl) {
                try {
                    unlink($pl);
                }
                catch (\Exception $exception) {
                    $this->plugin->getLogger()->error("Could not remove SynapsePM plugin - {$exception->getMessage()}");
                    return;
                }
            }
        }
    }
}