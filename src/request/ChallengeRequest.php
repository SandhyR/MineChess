<?php

namespace SandhyR\MineChess\request;


use pocketmine\nbt\ReaderTracker;
use pocketmine\player\Player;

class ChallengeRequest{

    public function __construct(private readonly Player $challenger, private readonly int $timeMode, private readonly bool $rated)
    {
    }

    /**
     * @return Player
     */
    public function getChallenger(): Player
    {
        return $this->challenger;
    }

    /**
     * @return int
     */
    public function getTimeMode(): int
    {
        return $this->timeMode;
    }

    /**
     * @return bool
     */
    public function isRated(): bool
    {
        return $this->rated;
    }

}
