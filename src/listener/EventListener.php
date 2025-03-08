<?php

namespace SandhyR\MineChess\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use SandhyR\MineChess\MineChess;

class EventListener implements Listener{

    public function onLogin(PlayerJoinEvent $event){
        MineChess::getInstance()->getSessionManager()->addSession($event->getPlayer());
    }

    public function onQuit(PlayerQuitEvent $event){
        MineChess::getInstance()->getSessionManager()->removeSession($event->getPlayer()->getName());
    }
}
