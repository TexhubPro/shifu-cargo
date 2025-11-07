<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registerpack extends Model
{
    protected $fillable = [
        'sklad',
        'weight',
        'type',
        'packages',
        'cube',
        'data',
    ];
}
