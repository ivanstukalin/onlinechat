<?php
const DB_HOST = 'localhost';
require 'vendor/autoload.php';
require 'app/autoload.php';

use Workerman\Worker;
use App\Controllers\MessageController;
use App\Entities;
use App\Services;
use App\Enums;

$worker        = new Worker('websocket://0.0.0.0:2346');
$worker->count = 4;
$chats         = [];
$chatService   = new Services\Chat();

$worker->onConnect = function ($connection) use (&$chatService, &$chats, &$test) {
    $connection->onWebSocketConnect = function($connection) use (&$chats, &$chatService, &$test): void {
        $chatId = $_GET['chat_id'];
        $userId = $_GET['user_id'] ?? null;
        $chat   = $chats[$chatId] ?? null;
        echo "Кол-во чатов: " . count($chats) . "\n";
        if (is_null($chat) && !is_null($userId)) {
            $chats[$chatId] = $chatService->prepareChat((int)$chatId, (int)$userId, $connection);
        }
        echo "Кол-во чатов: " . count($chats) . "\n";

        $operatorId = $_GET['operator_id'] ?? null;

        if (!is_null($operatorId) && !is_null($chat)) {
            $chatService->setOperator($chat, $operatorId, $connection);
        }
    };
    echo "Кол-во чатов: " . count($chats) . "\n";
    echo "Соединение установлено \n";
};

$worker->onMessage = function ($connection, $data) use (&$chats, &$chatService): void {
    $data    = json_decode($data, true);
    if ($data['type'] === Enums\MessageTypeEnum::System->value) {
        echo "Системное сообщениe \n";
        $chatService->handleSystemMessage($chats[$data['chat_id']], $data['text']);
        return;
    }
    $message = MessageController::create($data['text'], $data['chat_id'], $data['senders_id'], $data['type']);

    /** @var Entities\Chat $chat */
    $chat = $chats[$message->chat_id];
    if (is_null($chat?->getUserId()) || is_null($chat?->getOperatorId())) {
        return;
    }
    $connectionToSend = match ($message->type) {
        Enums\MessageTypeEnum::User => $chat->operatorConnection,
        Enums\MessageTypeEnum::Operator => $chat->userConnection,
    };
    $chatService->sendMessage($connectionToSend, $message);
};

$worker->onClose = function ($connection): void {
    echo "Соединение прервано \n";
};

Worker::runAll();

