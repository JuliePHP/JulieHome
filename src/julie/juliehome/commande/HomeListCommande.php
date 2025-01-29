<?php

namespace julie\juliehome\commande;

use julie\juliehome\Main;
use julie\juliehome\managers\HomeManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;

class HomeListCommande extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("homelist.cmd");
        $this->setPermissionMessage(Main::getInstance()->getConfig()->get("no_perm:"));
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $config = Main::getInstance()->getConfig();
        if($sender instanceof Player){
            if (empty(HomeManager::$homeList[$sender->getName()])){
                $sender->sendMessage($config->get("no_home"));
                return;
            }
            $sender->sendMessage($config->get("homelist_header") . "\n" . implode(", ", array_keys(HomeManager::$homeList[$sender->getName()])));
        }
    }
}