<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;

    public function __construct(?string $from = null, ?string $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $start = $this->from ? Carbon::parse($this->from)->startOfDay() : null;
        $end = $this->to ? Carbon::parse($this->to)->endOfDay() : null;

        $query = User::query();

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        $users = $query->get();

        return $users->map(function ($user) {
            $orders = Order::where('user_id', $user->id);

            // Если нужно фильтровать по дате, можно передать в конструктор
            if ($this->from && $this->to) {
                $orders->whereBetween('created_at', [
                    Carbon::parse($this->from)->startOfDay(),
                    Carbon::parse($this->to)->endOfDay()
                ]);
            }

            $orders = $orders->get();

            return [
                'special_code' => $user->id, // или $user->custom_code
                'name' => $user->name,
                'phone' => $user->phone,
                'gender' => $user->sex ?? '—', // 'мужской' / 'женский'
                'orders_count' => $orders->count(),
                'orders_sum' => $orders->sum('total'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Спец код',
            'Имя',
            'Телефон',
            'Пол',
            'Количество заказов',
            'Сумма заказов',
        ];
    }
}
