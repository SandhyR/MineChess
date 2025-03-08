<?php

namespace SandhyR\MineChess\form;

use Chess\Variant\Losing\M;
use pocketmine\player\Player;
use pocketmine\Server;
use SandhyR\MineChess\game\Game;
use SandhyR\MineChess\MineChess;
use SandhyR\MineChess\request\ChallengeRequest;
use SandhyR\MineChess\session\Session;
use Vecnavium\FormsUI\CustomForm;
use Vecnavium\FormsUI\SimpleForm;

class FormManager{

    public static function sendMainForm(Player $player){
        $form = new SimpleForm(function (Player $player, $data = null){
            if($data === null){
                return;
            }
            switch ($data){
                case 0:
                    self::sendChallengeForm($player);
                    break;
                case 1:
                    self::sendRequestForm($player);

            }
        });
        $form->setTitle("Chess");
        $form->addButton("Challenge");
        $form->addButton("Request");
        $player->sendForm($form);
    }

    public static function sendChallengeForm(Player $player){
        $onlinePlayers = array_values(Server::getInstance()->getOnlinePlayers());
        $playerList = [];
        foreach ($onlinePlayers as $onlinePlayer){
            if ($onlinePlayer->getName() !== $player->getName()){
                $playerList[] = $onlinePlayer->getName();
            }
        }
        $form = new CustomForm(function (Player $player, $data = null) use ($playerList){
            if($data === null){
                return;
            }
            $request = new ChallengeRequest($player, $data[1], $data[2]);
            $challengeSession = MineChess::getInstance()->getSessionManager()->getSession($playerList[$data[0]]);
            if ($challengeSession instanceof Session){
                $challengeSession->addRequest($request);
                $player->sendMessage("Sending chess request to " . $challengeSession->getPlayer()->getName() . " Playing " .  Game::timeModes[$data[1]] . " " . ($data[2] ? "Rated" : "Unrated"));
                $player->sendMessage($player->getName() . " has challenged you to a " . Game::timeModes[$data[1]] . " chess match " . ($data[2] ? "Rated" : "Unrated") . "\n" . "Type /chess to accept|refuse");
            } else {
                $player->sendMessage("Player was not found");
            }
        });
        $form->setTitle("Challenge");
        $form->addDropdown("Select player to challenge", $playerList);
        $form->addDropdown("Select time mode", Game::timeModes);
        $form->addToggle("Rated", true);

        $player->sendForm($form);
    }

    public static function sendRequestForm(Player $player){
        $requests = MineChess::getInstance()->getSessionManager()->getSession($player->getName())->getRequests();
        $form = new SimpleForm(function (Player $player, $data = null){
            if($data === null){
                return;
            }
        });
        $form->setTitle("Requests");
        foreach ($requests as $request){
            /** @var $request ChallengeRequest */
            $form->addButton($request->getChallenger()->getName() . " | " . Game::timeModes[$request->getTimeMode()] . " | " . ($request->isRated() ? "Rated" : "Unrated"))           ;
        }
        $player->sendForm($form);
    }

}
