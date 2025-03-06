<?php

namespace SandhyR\MineChess\block;

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

class BlockRegister {

    const GEOMETRY = ["king" => "geometry.king", "queen" => "geometry.queen", "bishop" => "geometry.bishop", "pawn" => "geometry.pawn", "knight" => "geometry.knight", "rook" => "geometry.rook"];

    public static function register(){
        foreach (self::GEOMETRY as $key => $value){
            $creativeInfo = new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_NATURE, CreativeInventoryInfo::GROUP_WOOD);
            $materialWhite = new Material(Material::TARGET_ALL, "white", Material::RENDER_METHOD_ALPHA_TEST);
            $modelWhite = new Model([$materialWhite], $value, new Vector3(-8, 0, -8), new Vector3(16, 16, 16));
            CustomiesBlockFactory::getInstance()->registerBlock(static fn()  => new Block(new BlockIdentifier(BlockTypeIds::newId()), "White " . ucfirst($key) , new BlockTypeInfo(new BlockBreakInfo(1))), "chess:white_" . $key, $modelWhite, $creativeInfo);
            $materialBlack = new Material(Material::TARGET_ALL, "black", Material::RENDER_METHOD_ALPHA_TEST);
            $modelBlack = new Model([$materialBlack], $value, new Vector3(-8, 0, -8), new Vector3(16, 16, 16));
            CustomiesBlockFactory::getInstance()->registerBlock(static fn()  => new Block(new BlockIdentifier(BlockTypeIds::newId()), "Black " . ucfirst($key) , new BlockTypeInfo(new BlockBreakInfo(1))), "chess:black_" . $key, $modelBlack, $creativeInfo);
        }
    }

}
