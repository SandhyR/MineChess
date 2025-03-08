<?php

namespace SandhyR\MineChess\session;

use pocketmine\player\Player;

class SessionManager{

    /** @var Session[] */
    private array $sessions;

    public function addSession(Player $player): void{
        $this->sessions[strtolower($player->getName())] = new Session($player, []);
    }

    public function getSession(string $name): ?Session{
        return $this->sessions[strtolower($name)] ?? null;
    }

    public function removeSession(string $name): void{
        unset($this->sessions[strtolower($name)]);
    }
}
