<?php

namespace SandhyR\MineChess\game;

use Chess\Variant\Classical\Board;
use customiesdevs\customies\block\CustomiesBlockFactory;
use customiesdevs\customies\Customies;
use pocketmine\item\Minecart;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\World;
use SandhyR\MineChess\MineChess;
use SandhyR\MineChess\utils\Utils;
use SandhyR\MineChess\world\WorldConfig;

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
            MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock($posWhite, CustomiesBlockFactory::getInstance()->get('chess:white_pawn'));
            $posBlack = Utils::fromChessCoord($value . 7, $pos1, $pos2);
            MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock($posBlack, CustomiesBlockFactory::getInstance()->get('chess:black_pawn'));
        }

        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("a1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_rook'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("b1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_knight'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("c1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_bishop'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("d1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_queen'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("e1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_king'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("f1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_bishop'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("g1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_knight'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("h1", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:white_rook'));

        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("a8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_rook'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("b8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_knight'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("c8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_bishop'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("d8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_queen'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("e8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_king'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("f8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_bishop'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("g8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_knight'));
        MineChess::getInstance()->getWorldConfig()->getWorld()->setBlock(Utils::fromChessCoord("h8", $pos1, $pos2), CustomiesBlockFactory::getInstance()->get('chess:black_rook'));

    }
}
