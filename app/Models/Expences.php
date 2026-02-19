<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expences extends Model
{
    protected $fillable = [
        'sklad',
        'total',
        'content',
        'data',
        'user_id',
        'added_by_id',
        'warehouse_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public static function forPeriodAll($start, $end)
    {
        return self::where('data', '>=', $start . ' 00:00:00')
            ->where('data', '<=', $end . ' 23:59:59')
            ->get();
    }
    public static function forPeriodIvu($start, $end)
    {
        return self::where('data', '>=', $start . ' 00:00:00')
            ->where('data', '<=', $end . ' 23:59:59')
            ->where('sklad', 'Склад Иву')
            ->get();
    }
    public static function forPeriodDushanbe($start, $end)
    {
        return self::where('data', '>=', $start . ' 00:00:00')
            ->where('data', '<=', $end . ' 23:59:59')
            ->where('sklad', 'Склад Душанбе')
            ->get();
    }
    public static function forPeriodCubeIvu($start, $end)
    {
        return self::where('data', '>=', $start . ' 00:00:00')
            ->where('data', '<=', $end . ' 23:59:59')
            ->where('sklad', 'Кубатура Иву')
            ->get();
    }
    public static function forPeriodCubeDushanbe($start, $end)
    {
        return self::where('data', '>=', $start . ' 00:00:00')
            ->where('data', '<=', $end . ' 23:59:59')
            ->where('sklad', 'Кубатура Душанбе')
            ->get();
    }
}
