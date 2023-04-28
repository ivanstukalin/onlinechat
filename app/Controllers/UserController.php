<?php

namespace App\Controllers;

use App\Exceptions\ChatNotFound;
use App\Exceptions\UserNotFound;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Capsule\Manager as DB;

class UserController
{
    private const DEFAULT_USER_NAME = 'Anonymous';

    /**
     * @throws UserNotFound
     */
    static public function get(int $userId): User
    {
        $user = User::query()->where('id', $userId)->get()->first();

        if (is_null($user)) {
            throw new UserNotFound($userId);
        }

        return $user;
    }

    /**
     * @throws \Exception
     */
    static public function create(int $chatId): User
    {
        /** @var Chat $chat */
        $chat = Chat::query()->where('id', $chatId)->get()->first();

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