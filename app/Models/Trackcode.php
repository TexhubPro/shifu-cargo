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
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public static function forPeriod($start, $end)
    {
        return self::where('china', '>=', $start . '00:00:00')
            ->where('china', '<=', $end . '23:59:59')
            ->where('status', 'Получено в Иву')
            ->count();
    }
}
