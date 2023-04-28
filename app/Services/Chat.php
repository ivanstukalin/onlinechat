<?php

namespace App\Services;

use App\Enums\ChatStatusEnum;
use App\Enums\MessageTypeEnum;
use App\Enums\SystemMessageEnum;
use App\Exceptions\ChatNotFound;
use App\Exceptions\OperatorDoesNotExist;
use http\Message;
use Workerman\Connection\TcpConnection;
use App\Entities;
use App\Models;

class Chat
{
    public array $chats;
    /**
     * @throws ChatNotFound
     */
    public function prepareChat(int $chatId, int $userId, TcpConnection $userConnection): Entities\Chat
    {
        if (!Models\Chat::query()->where('id', $chatId)->exists()) {
            throw new ChatNotFound($chatId);
        }
        $chat = new Entities\Chat();
        $chat->id = $chatId;
        $chat->userId = $userId;
        $chat->userConnection = $userConnection;

        return $chat;
    }

    /**
     * @throws OperatorDoesNotExist
     */
    public function setOperator(Entities\Chat $chat, int $operatorId, TcpConnection $connection): void
    {
        if (!Models\Operator::query()->where('id', $operatorId)->exists()) {
            throw new OperatorDoesNotExist($operatorId);
        }

        /** @var Models\Chat $chatModel */
        $chatModel = Models\Chat::query()->where('id', $chat->id)->first();
        $chatModel->operator_id = $operatorId;
        $chatModel->save();

        $chat->operatorId = $operatorId;
        $chat->operatorConnection = $connection;
        $this->handleSystemMessage($chat, SystemMessageEnum::OperatorActive->value);
    }

    public function sendMessage(TcpConnection $connection, Models\Message $message): void
    {
        $connection->send(json_encode($message));
        echo "Отправил сообщение $message->text, по адресу {$connection->getRemoteIp()}\n";
    }

    public function handleSystemMessage(Entities\Chat $chat, string $text): void
    {
        switch ($text) {
            case SystemMessageEnum::OperatorActive->value:
                $this->sendSystemMessage([
                        'text' => SystemMessageEnum::OperatorActive->value,
                        'type' => MessageTypeEnum::System->value,
                    ],
                    $chat->userConnection
                );
                break;
            case SystemMessageEnum::QuestionClosed->value:
                $chatModel = Models\Chat::query()->where('id', $chat->id)->get()->first();
                $chatModel->status = ChatStatusEnum::Closed;
                $chatModel->save();

                $this->sendSystemMessage([
                        'text' => SystemMessageEnum::QuestionClosed->value,
                        'type' => MessageTypeEnum::System->value,
                    ],
                    $chat->operatorConnection
                );
                break;
        }
    }

    private function sendSystemMessage(array $message, TcpConnection $connection): void
    {
        try {
            $connection->send(json_encode($message));
            echo "Отправил системное сообщение \n";
        } catch (\Throwable $exception) {
            echo "Системноее сообщение не было отправлено: {$exception->getMessage()}";
        }
    }
}