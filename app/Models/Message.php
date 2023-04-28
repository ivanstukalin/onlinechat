<?php

namespace App\Models;

use App\Enums\MessageTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Message
 *
 * @property int             $id
 * @property int             $sender_id
 * @property int             $chat_id
 * @property string          $text
 * @property MessageTypeEnum $type
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 */
class Message extends Model implements \JsonSerializable
{
    protected $table = 'messages';

    protected $casts = [
        'type' => MessageTypeEnum::class,
    ];

    public function toArray()
    {
        return [
            'id'      => $this->id,
            'chat_id' => $this->chat_id,
            'user_id' => $this->sender_id,
            'text'    => $this->text,
            'type'    => $this->type,
            'created_at' => $this->created_at->format('d.m.y h:m:s')
        ];
    }
}