<?php

namespace SandhyR\MineChess\game;


use pocketmine\player\Player;

class GameManager{

    /** @var Game[] */
    public array $games = [];


    public function newGame(Player $player1 = null, Player $player2 = null, bool $rated = false, int $timeMode = 0){
        $game = new Game([$player1, $player2], $rated, $timeMode);
        $this->games[] = $game;
        $game->start();
    }

}
