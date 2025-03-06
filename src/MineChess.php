<?php

namespace SandhyR\MineChess;

use customiesdevs\customies\block\CustomiesBlockFactory;
use customiesdevs\customies\block\Material;
use customiesdevs\customies\block\Model;
use customiesdevs\customies\item\CreativeInventoryInfo;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\BlockTypeInfo;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use SandhyR\MineChess\block\BlockRegister;
use SandhyR\MineChess\game\GameManager;
use SandhyR\MineChess\utils\Utils;
use SandhyR\MineChess\world\WorldConfig;

class MineChess extends PluginBase {
    use SingletonTrait;

    private GameManager $gameManager;
    private WorldConfig $worldConfig;


    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        if (!$this->getServer()->getWorldManager()->loadWorld($this->getConfig()->get('world')['name'])){
            $this->getLogger()->info('Chess world is not found, using default world..');
            $default = [
                "name" => "chess",
                "pos1" => [
                    "x" => 267,
                    "y" => 5,
                    "z" => 251
                ],
                "pos2" => [
                    "x" => 260,
                    "y" => 5,
                    "z" => 258
                ]
            ];
            $this->getConfig()->set('world', $default);
            Utils::copyFolder($this->getFile() . "/resources/world/", $this->getServer()->getDataPath() . "/worlds");
            $this->getServer()->getWorldManager()->loadWorld($this->getConfig()->get('world')['name']);
        }
        $worldConfig = $this->getConfig()->get('world');
        $this->worldConfig = new WorldConfig($worldConfig['name'], $worldConfig['pos1'], $worldConfig['pos2']);
        $this->gameManager = new GameManager();
        BlockRegister::register();
    }

    /**
     * @return GameManager
     */
    public function getGameManager(): GameManager
    {
        return $this->gameManager;
    }

    /**
     * @return WorldConfig
     */
    public function getWorldConfig(): WorldConfig
    {
        return $this->worldConfig;
    }

}
