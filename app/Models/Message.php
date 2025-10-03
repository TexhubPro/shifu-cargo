<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'message',
        'photo',
        'status',
        'is_admin',
    ];
}
