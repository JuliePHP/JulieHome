<?php

namespace julie\juliehome;

use julie\juliehome\commande\DelHome;
use julie\juliehome\commande\Home;
use julie\juliehome\commande\HomeList;
use julie\juliehome\commande\Sethome;
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
            new Sethome("sethome", $config->get("sethome_descritpion"), "/sethome <name>", ["addhome <name>"]),
            new DelHome("delhome", $config->get("delhome_descritpion"), "/delhome <name>", ["removehome <name>"]),
            new Home("home", $config->get("home_descritpion"), "/home <name>"),
            new HomeList("homelist", $config->get("homelist_descritpion"), "/homelist"),
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