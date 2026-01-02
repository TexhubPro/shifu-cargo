<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelivererPayment extends Model
{
    protected $fillable = [
        'deliverer_id',
        'cashier_id',
        'amount',
        'note',
    ];

    public function deliverer()
    {
        return $this->belongsTo(User::class, 'deliverer_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
}
