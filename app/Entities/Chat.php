<?php

namespace App\Entities;

use Workerman\Connection\TcpConnection;

class Chat
{
    public int            $id;
    public int            $userId;
    public ?int           $operatorId;
    public TcpConnection  $userConnection;
    public ?TcpConnection $operatorConnection;
}