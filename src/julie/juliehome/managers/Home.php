<?php

namespace julie\juliehome\managers;

use pocketmine\Server;
use pocketmine\world\Position;

class Home
{
    public function __construct(
        public string $name,
        public Position $position
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPosition(Position $position): void
    {
        $this->position = $position;
    }
    public function __serialize(): array {
        return [
            'name' => $this->name,
            'x' => $this->position->getX(),
            'y' => $this->position->getY(),
            'z' => $this->position->getZ(),
            'world' => $this->position->getWorld()->getFolderName()
        ];
    }

    public function __unserialize(array $data): void {
        $this->name = $data['name'];
        $world = Server::getInstance()->getWorldManager()->getWorldByName($data['world']);
        if ($world === null) {
            throw new \RuntimeException("World '{$data['world']}' not found");
        }
        $this->position = new Position($data['x'], $data['y'], $data['z'], $world);
    }
}