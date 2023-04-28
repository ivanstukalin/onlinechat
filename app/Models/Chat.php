<?php

namespace App\Models;

use App\Enums\ChatStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Chat
 *
 * @property int         $id
 * @property int         $operator_id
 * @property int         $user_id
 * @property string      $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Chat extends Model implements \JsonSerializable
{
    protected $table = 'chats';

    protected $casts = [
        'type' => ChatStatusEnum::class,
    ];
}