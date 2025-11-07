<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expences extends Model
{
    protected $fillable = [
        'sklad',
        'total',
        'content',
        'data'
    ];
}
