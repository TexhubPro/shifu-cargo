<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'cashier_id',
        'warehouse_id',
        'application_id',
        'weight',
        'cube',
        'subtotal',
        'delivery_total',
        'deliver_id',
        'discount',
        'total',
        'status',
        'payment_type',
        'photo_report_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function deliver()
    {
        return $this->belongsTo(User::class, 'deliver_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public static function forPeriod($start, $end)
    {
        return self::where('created_at', '>=', $start . ' 00:00:00')
            ->where('created_at', '<=', $end . ' 23:59:59')
            ->get();
    }
}
