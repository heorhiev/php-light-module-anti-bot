<?php

namespace app\supportBot\commands;

use app\claimBot\constants\ClaimBotConst;


class CallsCommand extends \app\bot\services\Command
{
    public function run(): void
    {
        $this->getBot()->sendMessage($this->getUserId(), ClaimBotConst::STEP_ENTER_NAME);
    }
}