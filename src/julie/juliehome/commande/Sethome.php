<?php

namespace julie\juliehome\commande;

use julie\juliehome\Main;
use julie\juliehome\managers\Home;
use julie\juliehome\managers\HomeManager;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;

class Sethome extends Command
{
    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $config = Main::getInstance()->config("config");
        if ($sender instanceof Player){
            if (isset(HomeManager::$homeList[$sender->getName()]) && count(HomeManager::$homeList[$sender->getName()]) >= $config->get("max_home")){
                $sender->sendMessage($config->get("max_home_message"));
            }else{
                if (empty($args[0])) {
                    $sender->sendMessage(str_replace("{usage}", $this->getUsage(), $config->get("usage_message")));
                    return;
                }
                $homename = $args[0];
                if (strlen($homename) >= $config->get("max_name_length")){
                    $sender->sendMessage($config->get("max_name_length_message"));
                    return;
                }
                if (in_array($homename, $config->get("invalid_name", ["list"]))){
                    $sender->sendMessage($config->get("invalid_name_message"));
                    return;
                }
                $sender->sendMessage($config->get("sethome_message"));
                HomeManager::addHome($sender, new Home($homename, $sender->getPosition()));
            }
        }
    }
}