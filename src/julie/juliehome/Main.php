<?php

namespace julie\juliehome;

use julie\juliehome\commande\DelHomeCommande;
use julie\juliehome\commande\HomeCommande;
use julie\juliehome\commande\HomeListCommande;
use julie\juliehome\commande\SethomeCommande;
use julie\juliehome\managers\HomeManager;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase
{
    use SingletonTrait;
    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $config = $this->getConfig();
        HomeManager::load();
        $this->getServer()->getCommandMap()->registerAll("", [
            new SethomeCommande("sethome", $config->get("sethome_descritpion"), "/sethome <name>", ["addhome <name>"]),
            new DelHomeCommande("delhome", $config->get("delhome_descritpion"), "/delhome <name>", ["removehome <name>"]),
            new HomeCommande("home", $config->get("home_descritpion"), "/home <name>"),
            new HomeListCommande("homelist", $config->get("homelist_descritpion"), "/homelist", ["homes"]),
        ]);
    }
    protected function onDisable(): void
    {
        HomeManager::unload();
    }
    public function config(string $name): Config
    {
        return new Config($this->getDataFolder() . $name . ".yml", Config::YAML);
    }
}