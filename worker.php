<?php
require './vendor/autoload.php';

use Workerman\Worker;

$worker = new Worker('websocket://0.0.0.0:2346');
$worker->count = 4;

$worker->onConnect = function ($connection) {
    echo "Соединение прервано \n";
};

$worker->onMessage = function ($connection, $data) use ($worker) {
    $test = ['text' => 'еу',];
    $connection->send(json_encode($test));
};

$worker->onClose = function ($connection) {
    echo "Соединение прервано \n";
};

Worker::runAll();

