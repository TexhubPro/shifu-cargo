<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifyqueue extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'status',
    ];
}
