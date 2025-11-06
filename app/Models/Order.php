<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'weight',
        'cube',
        'subtotal',
        'delivery_total',
        'deliver_id',
        'discount',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deliver()
    {
        return $this->belongsTo(User::class, 'deliver_id');
    }
}
