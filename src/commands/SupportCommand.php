<?php

namespace app\supportBot\commands;

use app\claimBot\constants\ClaimBotConst;


class SupportCommand extends \app\bot\models\Command
{
    public function run(): void
    {
        $this->getBot()->sendMessage($this->getUserId(), ClaimBotConst::STEP_ENTER_NAME);
    }
}