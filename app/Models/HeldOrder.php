<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeldOrder extends Model
{
    protected $fillable = [
        'user_id',
        'client',
        'order_no',
        'deliver_boy',
        'queue_id',
        'delivery_price',
        'weight',
        'volume',
        'payment_type',
        'total_amount',
        'discount',
        'discount_total',
        'discountt',
        'total_final',
        'tracks',
        'meta',
    ];

    protected $casts = [
        'tracks' => 'array',
        'meta' => 'array',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
