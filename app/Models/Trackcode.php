<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trackcode extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'order_id',
        'china',
        'dushanbe',
        'customer',
        'race',
        'weight',
    ];
}
