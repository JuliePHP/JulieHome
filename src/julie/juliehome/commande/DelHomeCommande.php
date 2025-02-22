<?php

namespace julie\juliehome\commande;

use julie\juliehome\Main;
use julie\juliehome\managers\HomeManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;

class DelHomeCommande extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("delhome.cmd");
        $this->setPermissionMessage(Main::getInstance()->getConfig()->get("no_perm:"));
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $config = Main::getInstance()->config("config");
        if ($sender instanceof Player){
            if (empty($args[0])) {
                $sender->sendMessage(str_replace("{usage}", $this->getUsage(), $config->get("usage_message")));
                return;
            }
            $homename = $args[0];
            if (in_array($homename, array_keys(HomeManager::$homeList[$sender->getName()]) ?? [])) {
                HomeManager::removeHome($sender, $homename);
                $sender->sendMessage($config->get("delhome_message"));
            }else{
                $sender->sendMessage($config->get("dont_find_home"));
            }
        }
    }
}