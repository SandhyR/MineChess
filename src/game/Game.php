<?php

namespace SandhyR\MineChess\game;

use Chess\Variant\Classical\Board;
use customiesdevs\customies\block\CustomiesBlockFactory;
use pocketmine\player\Player;
use pocketmine\world\World;
use SandhyR\MineChess\async\DuplicateWorldTask;
use SandhyR\MineChess\MineChess;
use SandhyR\MineChess\utils\Utils;

class Game {

    const BULLET = 0;
    const BLITZ = 1;
    const RAPID = 2;

    const timeModes = ["Bullet | 1 Min", "Blitz | 3 Min", "Rapid | 10 Min"];


    /** @var Player[] */
    private array $players = [];

    private string $turn = 'w';

    private World $world;

    private Board $board;

    public function __construct(array $players, private bool $rated, private int $timeMode){
        shuffle($players);
        $this->players = [
            'w' => $players[0],
            'b' => $players[1]
        ];
        $this->board = new Board();
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

    public function initBlock(){
        $letter = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $pos1 = MineChess::getInstance()->getWorldConfig()->getPos1();
        $pos2 = MineChess::getInstance()->getWorldConfig()->getPos2();

        foreach ($letter as $value){
            $posWhite = Utils::fromChessCoord($value . 2, $pos1, $pos2);
           $this->world->setBlock($posWhite, CustomiesBlockFactory::getInstance()->get('chess:white_pawn'));
            $posBlack = Utils::fromChessCoord($value . 7, $pos1, $pos2);
           $this->world->setBlock($posBlack, CustomiesBlockFactory::getInstance()->get('chess:black_pawn'));
        }

        //too lazy for this
        $this->world->setBlock(Utils::fromChessCoord("a1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_rook'));
       $this->world->setBlock(Utils::fromChessCoord("b1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_knight'));
       $this->world->setBlock(Utils::fromChessCoord("c1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_bishop'));
       $this->world->setBlock(Utils::fromChessCoord("d1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_queen'));
       $this->world->setBlock(Utils::fromChessCoord("e1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_king'));
       $this->world->setBlock(Utils::fromChessCoord("f1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_bishop'));
       $this->world->setBlock(Utils::fromChessCoord("g1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_knight'));
       $this->world->setBlock(Utils::fromChessCoord("h1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_rook'));

       $this->world->setBlock(Utils::fromChessCoord("a8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_rook'));
       $this->world->setBlock(Utils::fromChessCoord("b8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_knight'));
       $this->world->setBlock(Utils::fromChessCoord("c8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_bishop'));
       $this->world->setBlock(Utils::fromChessCoord("d8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_queen'));
       $this->world->setBlock(Utils::fromChessCoord("e8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_king'));
       $this->world->setBlock(Utils::fromChessCoord("f8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_bishop'));
       $this->world->setBlock(Utils::fromChessCoord("g8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_knight'));
       $this->world->setBlock(Utils::fromChessCoord("h8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_rook'));
    }

    public function start(){
        MineChess::getInstance()->getServer()->getAsyncPool()->submitTask(new DuplicateWorldTask(function (string $worldName){
            MineChess::getInstance()->getServer()->getWorldManager()->loadWorld($worldName);
            $this->world = MineChess::getInstance()->getServer()->getWorldManager()->getWorldByName($worldName);
            $this->initBlock();
        }));


    }
}
