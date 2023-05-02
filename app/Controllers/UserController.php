<?php

namespace App\Controllers;

use App\Exceptions\ChatNotFound;
use App\Exceptions\UserNotFound;
use App\Models\Chat;
use App\Models\User;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{
    private const DEFAULT_USER_NAME = 'Anonymous';

    /**
     * @throws UserNotFound
     */
    static public function get(ServerRequestInterface $request): User
    {
        $userId = $request->getQueryParams()['id'];
        $user   = User::query()->where('id', $userId)->get()->first();

        if (is_null($user)) {
            throw new UserNotFound($userId);
        }

        return $user;
    }

    /**
     * @throws \Exception
     */
    static public function create(ServerRequestInterface $request): User
    {
        $chatId = $request->getParsedBody()['chat_id'];
        /** @var Chat $chat */
        $chat  = Chat::query()->where('id', $chatId)->get()->first();

        if (is_null($chat)) {
            throw new ChatNotFound($chatId);
        }

        $user       = new User();
        $user->name = self::DEFAULT_USER_NAME;

        $user->save();
        $chat->user_id = $user->id;
        $chat->save();


        return $user;
    }
}