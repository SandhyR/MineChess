<?php

namespace SandhyR\MineChess\utils;

use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\utils\AssumptionFailedError;
use pocketmine\world\Position;
use pocketmine\world\World;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Utils{

    public static function removeWorld(string $name): int {
        if(Server::getInstance()->getWorldManager()->isWorldLoaded($name)) {
            $world = Server::getInstance()->getWorldManager()->getWorldByName($name);
            if ($world instanceof World){
            if(count($world->getPlayers()) > 0) {
                foreach ($world->getPlayers() as $player) {
                    $player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
                }
            }
            }

            Server::getInstance()->getWorldManager()->unloadWorld($world, true);
        }

        $removedFiles = 1;

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($worldPath = Server::getInstance()->getDataPath() . "/worlds/$name", FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
        /** @var SplFileInfo $fileInfo */
        foreach($files as $fileInfo) {
            if($filePath = $fileInfo->getRealPath()) {
                if($fileInfo->isFile()) {
                    unlink($filePath);
                } else {
                    rmdir($filePath);
                }

                ++$removedFiles;
            }
        }

        rmdir($worldPath);
        return $removedFiles;
    }

    public static function duplicateWorld(string $worldName, string $duplicateName): void {
        if(!Server::getInstance()->getWorldManager()->isWorldGenerated($worldName)) {
            throw new AssumptionFailedError("World \"$worldName\" is not generated.");
        }
        if(Server::getInstance()->getWorldManager()->isWorldLoaded($worldName)) {
            $world = Server::getInstance()->getWorldManager()->getWorldByName($worldName)?->save();
        }

        mkdir(Server::getInstance()->getDataPath() . "/worlds/$duplicateName");

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(Server::getInstance()->getDataPath() . "worlds/$worldName", FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
        /** @var SplFileInfo $fileInfo */
        foreach($files as $fileInfo) {
            if($filePath = $fileInfo->getRealPath()) {
                if($fileInfo->isFile()) {
                    @copy($filePath, str_replace($worldName, $duplicateName, $filePath));
                } else {
                    mkdir(str_replace($worldName, $duplicateName, $filePath));
                }
            }
        }
    }

    public static  function copyFolder(string $sourceFolder, string $destinationFolder) {
        if (!file_exists($destinationFolder)) {
            mkdir($destinationFolder, 0777, true);
        }
        $files = scandir($sourceFolder);
        foreach ($files as $file) {
            if ($file == "." || $file == "..") {
                continue;
            }
            $source = $sourceFolder . "/" . $file;
            $destination = $destinationFolder . "/" . $file;
            if (is_dir($source)) {
                self::copyFolder($source, $destination);
            } else {
                copy($source, $destination);
            }
        }
    }

    public static function toChessCoord(int $x, int $z, Vector3 $pos1, Vector3 $pos2)
    {

        $refX = 0;
        $refZ = 0;
        if ($pos1->getX() > $pos2->getX()) {
            if ($pos1->getZ() > $pos2->getZ()) {
                $refX = $pos1->getZ() - $z;
                $refZ = $pos1->getX() - $x;
            } else {
                $refX = $pos1->getX() - $x;
                $refZ = $z - $pos1->getZ();

            }
        } else {
            if ($pos1->getZ() > $pos2->getZ()) {
                $refX = $x - $pos1->getX();
                $refZ = $pos1->getZ() - $z;

            } else {
                $refX = $z - $pos1->getZ();
                $refZ = $x - $pos1->getX();
            }
        }
        $letter = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        return $letter[$refX] . $refZ + 1;
    }

    public static function fromChessCoord(string $position, Vector3 $pos1, Vector3 $pos2)
    {

        $letter = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $arr = str_split($position);
        $refX = array_search($arr[0], $letter);
        $refZ =  $arr[1] - 1;
        $x = 0;
        $z = 0;
        if ($pos1->getX() > $pos2->getX()) {
            if ($pos1->getZ() > $pos2->getZ()) {
                $x = $pos1->getX() - $refZ;
                $z = $pos1->getZ() - $refX;
            } else {
                $x = $pos1->getX() - $refX;
                $z = $pos1->getZ() + $refZ;

            }
        } else {
            if ($pos1->getZ() > $pos2->getZ()) {

                $x = $pos1->getX() + $refX;
                $z = $pos1->getZ() - $refZ;


            } else {
                $x = $pos1->getX() + $refZ;
                $z = $pos1->getZ() + $refX;
            }
        }
        return new Vector3($x, $pos1['y'], $z);
    }
}
