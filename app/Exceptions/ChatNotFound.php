<?php

namespace App\Exceptions;

class ChatNotFound extends \Exception
{
    public function __construct(int $chatId, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            "Chat {$chatId} not found.",
            404,
            $previous
        );
    }
}