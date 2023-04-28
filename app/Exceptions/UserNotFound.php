<?php

namespace App\Exceptions;

class UserNotFound extends \Exception
{
    public function __construct(int $userId, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            "User {$userId} not found.",
            404,
            $previous
        );
    }
}