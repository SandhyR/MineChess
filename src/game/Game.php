<?php

namespace SandhyR\MineChess\game;

use Chess\Variant\Classical\Board;
use pocketmine\player\Player;
use pocketmine\world\World;

class Game {

    /** @var Player[] */
    private array $players = [];

    private string $turn = 'w';

    private World $world;

    private Board $board;

    public function __construct(array $players){
        shuffle($players);
        $this->players = [
            'w' => $players[0],
            'b' => $players[1]
        ];
    }


    /**
     * @return string
     */
    public function getTurn(): string
    {
        return $this->turn;
    }

    public function setTurn(string $turn): void{
        $this->turn = $turn;
    }
}
