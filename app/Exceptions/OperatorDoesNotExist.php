<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class OperatorDoesNotExist extends \Exception
{
    public function __construct(int $operatorId, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            "Operator {$operatorId} does not exist",
            404,
            $previous
        );
    }
}