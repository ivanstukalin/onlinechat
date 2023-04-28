<?php

namespace App\Entities;

use Workerman\Connection\TcpConnection;

class Chat
{
    public int            $id;
    public int            $userId;
    public ?int           $operatorId = null;
    public TcpConnection  $userConnection;
    public ?TcpConnection $operatorConnection = null;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getOperatorId(): ?int
    {
        return $this->operatorId;
    }
}