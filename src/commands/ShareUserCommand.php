<?php

namespace light\module\antiBot\commands;

use light\i18n\Loco;
use light\module\antiBot\entities\Review;
use light\module\antiBot\entities\UserRequest;
use light\module\antiBot\helpers\MenuHelper;
use TelegramBot\Api\Types\SharedUser;


class ShareUserCommand extends \light\tg\bot\models\Command
{
    public static function getTitle(): string
    {
        return Loco::translate('Share user command');
    }


    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $requestId = $this->getBot()->getIncomeMessage()->getUserShared()->getRequestId();

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
        $recipientId = $this->getBot()->getIncomeMessage()->getUserShared()->getUserId();

        $this->getBot()->storeCommand(AddReviewCommand::class, (string) $recipientId);

        $message = $this->getBot()->getNewMessage();

        $message->setMessageView('{@antiBotViews}/review_add/start');

        $message->setKeyboardMarkup(MenuHelper::getCancelMenuKeyboard());

        $this->getBot()->sendMessage($message);
    }


    public function getReviews(): void
    {
        $recipientId = $this->getBot()->getIncomeMessage()->getUserShared()->getUserId();

        /** @var Review[] $reviews */
        $reviews = Review::repository()->filter(['recipient_id' => $recipientId])->asEntityAll();

        $message = $this->getBot()->getNewMessage();

        if ($reviews) {
            $message->setMessageView('{@antiBotViews}/reviews_get/list');
            $message->setAttributes(['reviews' => $reviews]);
        } else {
            $message->setMessageView('{@antiBotViews}/reviews_get/empty');
            $message->setAttributes(['reviews' => $reviews]);
        }

        $this->getBot()->sendMessage($message);
    }
}