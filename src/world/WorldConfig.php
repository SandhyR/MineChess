<?php

namespace SandhyR\MineChess\world;

use pocketmine\item\Minecart;
use pocketmine\world\Position;
use pocketmine\world\World;
use SandhyR\MineChess\MineChess;

class WorldConfig{

    public function __construct(private string $world, private array $pos1, private array $pos2)
    {
    }

    public function getWorld(): ?World{
        return MineChess::getInstance()->getServer()->getWorldManager()->getworld($this->world);
    }

    /**
     * Pos1 is position in bottom left start from the white, or a1
     */
    public function getPos1(): ?Position{
        $pos1 = $this->pos1;
        $pos = new Position($pos1['x'], $pos1['y'], $pos1['z'], $this->getWorld());
        return $pos;
    }

    /**
     * Pos2 is position in top right start from the white, or h8
     */
    public function getPos2(): ?Position{
        $pos2 = $this->pos2;
        $pos = new Position($pos2['x'], $pos2['y'], $pos2['z'], $this->getWorld());
        return $pos;
    }
}
