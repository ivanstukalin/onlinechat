<?php

namespace App\Controllers;

use App\Enums\ChatStatusEnum;
use App\Exceptions\ChatNotFound;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Operator;
use App\Models\User;

class ChatController
{
    static public function get(int $chatId): Chat
    {
        $chat = self::getChat($chatId);

        return $chat;
    }

    static public function listActive(): array
    {
        return Chat::query()->get()->where('status', ChatStatusEnum::Active->value)->toArray();
    }

    static public function getUser(int $chatId): User
    {
        $chat = self::getChat($chatId);

        return User::query()->where('id', $chat->user_id)->get()->first();
    }

    static public function getOperator(int $chatId): Operator
    {
        $chat = self::getChat($chatId);

        return Operator::query()->where('id', $chat->operator_id)->get()->first();
    }

    static public function getMessages(int $chatId): array
    {
        $chat = self::getChat($chatId);

        return Message::query()->where('chat_id', $chat->id)->get()->toArray();
    }

    static public function create(): Chat {
        $chat = new Chat();
        $chat->status = ChatStatusEnum::Active;
        $chat->save();
        return $chat;
    }

    /**
     * @throws ChatNotFound
     */
    static public function getChat(int $chatId): Chat
    {
        $chat = Chat::query()->where('id', $chatId)->get()->first();

        if (is_null($chat)) {
            throw new ChatNotFound($chatId);
        }

        return $chat;
    }
}