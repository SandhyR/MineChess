<?php

namespace SandhyR\MineChess\session;

use pocketmine\player\Player;
use SandhyR\MineChess\request\ChallengeRequest;

class Session{

    public function __construct(private readonly Player $player, private array $requests = [])
    {
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return array
     */
    public function getRequests(): array
    {
        return $this->requests;
    }

    public function addRequest(ChallengeRequest $request): void{
        $this->requests[] = $request;
    }

}
