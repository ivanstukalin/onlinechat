<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * User
 *
 * @property int         $id
 * @property string      $name
 * @property int         $chat_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class User extends Model implements \JsonSerializable
{
    protected $table = 'users';
}