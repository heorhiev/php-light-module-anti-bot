<?php

namespace light\module\antiBot\commands;

use light\module\antiBot\entities\Review;
use light\module\antiBot\entities\User;


class AddReviewCommand extends \light\tg\bot\models\Command
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $reviewText = $this->getBot()->getIncomeMessage()->getText();

        $id = Review::repository()->create([
            'sender_id' => $this->getUserId(),
            'recipient_id' => $this->getRecipientId(),
            'text' => $reviewText,
        ]);

        if (empty($id)) {
            throw new \Exception('Error creating review');
        }

        $message = $this->getBot()->getNewMessage();

        $message->setMessageView('{@antiBotViews}/add_review/thanks');

        $this->getBot()->sendMessage($message);
    }


    private function getRecipientId(): int
    {
        /** @var User $user */
        $user = User::repository()->findById($this->getUserId())->asEntityOne();
        return $user?->command_data;
    }
}