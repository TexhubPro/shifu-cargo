<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'chat_id',
        'code',
        'lang',
        'warehouse_id',
        'step',
        'sub_step',
        'role',
        'status',
        'password',
        'sex',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function trackcodes()
    {
        return $this->hasMany(Trackcode::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public static function forPeriod($start, $end)
    {
        return self::where('created_at', '>=', $start . ' 00:00:00')
            ->where('created_at', '<=', $end . ' 23:59:59')
            ->get();
    }
}
