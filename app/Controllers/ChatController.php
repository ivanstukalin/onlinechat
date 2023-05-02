<?php

namespace App\Controllers;

use App\Enums\ChatStatusEnum;
use App\Exceptions\ChatNotFound;
use App\Exceptions\OperatorDoesNotSetForChat;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Operator;
use App\Models\User;
use Psr\Http\Message\ServerRequestInterface;

class ChatController
{
    static public function get(ServerRequestInterface $request): Chat
    {
        return self::getChatFromRequest($request);
    }

    static public function listActive(): array
    {
        return Chat::query()->get()->where('status', ChatStatusEnum::Active->value)->toArray();
    }

    static public function getUser(ServerRequestInterface $request): User
    {
        $chat = self::getChatFromRequest($request);

        return User::query()->where('id', $chat->user_id)->get()->first();
    }

    static public function getOperator(ServerRequestInterface $request): Operator
    {
        $chat     = self::getChatFromRequest($request);
        $operator = Operator::query()->where('id', $chat->operator_id)->get()->first();

        if (is_null($operator)) {
            throw new OperatorDoesNotSetForChat($chat->id);


        }
        return $operator;
    }

    static public function getMessages(ServerRequestInterface $request): array
    {
        $chat = self::getChatFromRequest($request);

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

    static private function getChatFromRequest(ServerRequestInterface $request): Chat {
        return self::getChat((int)$request->getQueryParams()['id']);
    }
}