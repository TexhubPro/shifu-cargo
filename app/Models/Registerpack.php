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
    public static function shipped($start, $end)
    {
        return self::where('data', '>=', $start . ' 00:00:00')
            ->where('data', '<=', $end . ' 23:59:59')
            ->where('sklad', 'Иву')
            ->get();
    }
    public static function received($start, $end)
    {
        return self::where('data', '>=', $start . ' 00:00:00')
            ->where('data', '<=', $end . ' 23:59:59')
            ->where('sklad', 'Душанбе')
            ->get();
    }
}
