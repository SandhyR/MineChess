<?php

namespace SandhyR\MineChess\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use SandhyR\MineChess\form\FormManager;

class ChessCommand extends Command {

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission("minechess.command");
    }


    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            FormManager::sendMainForm($sender);
        }
    }
}
