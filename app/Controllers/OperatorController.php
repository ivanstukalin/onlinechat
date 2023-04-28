<?php

namespace App\Controllers;

use App\Exceptions\OperatorDoesNotExist;
use App\Models\Operator;

class OperatorController
{
    /**
     * @throws OperatorDoesNotExist
     */
    static public function get(int $operatorId): Operator
    {
        $operator = Operator::query()->where('id', $operatorId)->get()->first();

        if (is_null($operator)) {
            throw new OperatorDoesNotExist($operatorId);
        }

        return $operator;
    }
}