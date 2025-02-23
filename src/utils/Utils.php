<?php

namespace SandhyR\MineChess\utils;

use pocketmine\Server;
use pocketmine\utils\AssumptionFailedError;
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

    public function toChessCoord($x, $z, $refX, $refZ) {
        // Calculate offset
        $colOffset = $x - $refX;
        $rowOffset = $z - $refZ;

        // Map to chessboard
        $columns = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $col = $columns[$colOffset];
        $row = 1 + $rowOffset; // Row starts at 1

        return $col . $row;
    }
}
