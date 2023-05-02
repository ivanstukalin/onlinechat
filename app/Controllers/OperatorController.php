<?php

namespace App\Controllers;

use App\Exceptions\OperatorDoesNotSetForChat;
use App\Models\Operator;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class OperatorController
{
    /**
     * @throws OperatorDoesNotSetForChat
     */
    static public function get(ServerRequestInterface $request): Operator
    {
        $operatorId = $request->getQueryParams()['id'];

        $operator = Operator::query()->where('id', $operatorId)->get()->first();

        if (is_null($operator)) {
            throw new OperatorDoesNotSetForChat($operatorId);
        }

        return $operator;
    }
}