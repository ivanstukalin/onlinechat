<?php

namespace App\Controllers;

use App\Enums\MessageTypeEnum;
use App\Exceptions\UserNotFound;
use App\Models\Message;
use App\Models\User;

class MessageController
{
    /**
     * @throws \Exception
     */
    static public function create(string $text, int $chatId, int $userId, string $type): Message
    {
        $user = User::query()->where('id', $userId)->get()->first();

        if (is_null($user)) {
            throw new UserNotFound($userId);
        }

        $message = new Message();
        $message->text = $text;
        $message->sender_id = $user->id;
        $message->chat_id = $chatId;
        $message->type    = match ($type) {
            MessageTypeEnum::User->value     => MessageTypeEnum::User,
            MessageTypeEnum::Operator->value => MessageTypeEnum::Operator,
        };
        $message->save();
        return $message;
    }
}