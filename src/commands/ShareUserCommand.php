<?php

namespace light\module\antiBot\commands;

use light\module\antiBot\entities\UserRequest;
use TelegramBot\Api\Types\SharedUser;


class ShareUserCommand extends \light\tg\bot\models\Command
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $requestId = $this->getBot()->getIncomeMessage()->getUsersShared()->getRequestId();

        /** @var UserRequest $request */
        $request = UserRequest::repository()->findById($requestId)->asEntityOne();

        if (empty($request)) {
            $message = $this->getBot()->getNewMessage();

            $message->setMessageView('{@antiBotViews}/share_detect');

            $this->getBot()->sendMessage($message);

            throw new \Exception("Share request #{$requestId} not found for user #{$this->getUserId()}");
        }

        if (method_exists($this, $request->command)) {
            call_user_func([$this, $request->command]);
        }

        throw new \Exception("Command not found for request");
    }


    public function addReview(): void
    {
        $recipientId = null;

        /** @var SharedUser[] $users */
        $users = $this->getBot()->getIncomeMessage()->getUsersShared()->getUsers();
        foreach ($users as $user) {
            $recipientId = $user->getUserId();
        }

        $this->getBot()->storeCommand(AddReviewCommand::class, (string) $recipientId);

        $message = $this->getBot()->getNewMessage();

        $message->setMessageView('{@antiBotViews}/add_review/start');

        $this->getBot()->sendMessage($message);
    }
}