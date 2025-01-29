<?php

namespace julie\juliehome\managers;

use julie\juliehome\Main;
use pocketmine\player\Player;

class HomeManager
{
    public static array $homeList = [];

    public static function load(): void {
        $raw = Main::getInstance()->config("home")->get("e");
        self::$homeList = is_bool($raw) ? [] : unserialize($raw);
    }

    public static function unload(): void {
        try {
            $serialize = serialize(self::$homeList);
            $config = Main::getInstance()->config("home");
            $config->set("e", $serialize);
            $config->save();
        } catch (\Throwable $e) {
            throw new \RuntimeException("Failed to unload home list: " . $e->getMessage(), 0, $e);
        }
    }


    public static function addHome(Player $player, Home $home): void {
        $playerName = $player->getName();
        if (!isset(self::$homeList[$playerName])) {
            self::$homeList[$playerName] = [];
        }

        self::$homeList[$playerName][$home->getName()] = $home;
    }

    public static function removeHome(Player $player, string $home): void {
        unset(self::$homeList[$player->getName()][$home]);
    }

    public static function getHome(Player $player, string $homeName): ?Home
    {
        return self::$homeList[$player->getName()][$homeName] ?? null;
    }

}