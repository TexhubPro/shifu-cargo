<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $fillable = [
        'no',
        'sex',
        'user_id',
        'status',
    ];
}
