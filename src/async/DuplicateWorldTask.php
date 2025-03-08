<?php

namespace SandhyR\MineChess\async;

use Closure;
use pocketmine\scheduler\AsyncTask;
use Ramsey\Uuid\Uuid;
use SandhyR\MineChess\MineChess;
use SandhyR\MineChess\utils\Utils;

class DuplicateWorldTask extends AsyncTask{

    public function __construct(Closure $onCompletion)
    {
        $this->storeLocal("onCompletion", $onCompletion);
    }


    public function onRun(): void
    {
        $uuid = Uuid::uuid4();
        Utils::duplicateWorld(MineChess::getInstance()->getWorldConfig()->getWorld()->getFolderName(), $uuid);
        $this->setResult($uuid);
    }

    public function onCompletion(): void
    {
        $closure = $this->fetchLocal("onCompletion");
        ($closure)($this->getResult());
    }
}
