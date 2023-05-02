<?php

namespace App\Exceptions;

class OperatorDoesNotSetForChat extends \Exception
{
    public function __construct(int $chatId, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            "Operator does not set for chat №{$chatId}",
            404,
            $previous
        );
    }
}