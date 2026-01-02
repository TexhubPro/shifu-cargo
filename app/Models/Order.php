<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'application_id',
        'weight',
        'cube',
        'subtotal',
        'delivery_total',
        'deliver_id',
        'discount',
        'total',
        'status',
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
