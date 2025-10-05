<?php

namespace App\Livewire\Admin;

use App\Models\Expences;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use App\Models\Trackcode;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public array $data = [
        ['date' => '2025-10-08', 'visitors' => 1532],
        ['date' => '2025-10-07', 'visitors' => 259],
        ['date' => '2025-10-06', 'visitors' => 269],
        ['date' => '2025-10-05', 'visitors' => 555],
        ['date' => '2025-10-04', 'visitors' => 3445],
        ['date' => '2025-10-03', 'visitors' => 434],
        ['date' => '2025-10-02', 'visitors' => 34],
        ['date' => '2025-10-01', 'visitors' => 4566],
    ];
    public $newUsersCount;
    public $trackcodesCount;
    public $ordersSum;
    public $expensesSum;
    public $montnewUsersCount;
    public $monttrackcodesCount;
    public $montordersSum;
    public $montexpensesSum;
    public function mount()
    {
        $start = Carbon::now('Asia/Dushanbe')->startOfDay();
        $end   = Carbon::now('Asia/Dushanbe')->endOfDay();

        $this->newUsersCount = User::whereBetween('created_at', [$start, $end])->count();

        $this->trackcodesCount = Trackcode::whereBetween('created_at', [$start, $end])->count();

        $this->ordersSum = Order::whereBetween('created_at', [$start, $end])
            ->sum('total');

        $this->expensesSum = Expences::whereBetween('created_at', [$start, $end])
            ->sum('total');
        $montstart = Carbon::now('Asia/Dushanbe')->startOfMonth()->setTimezone('UTC');
        $montend   = Carbon::now('Asia/Dushanbe')->endOfMonth()->setTimezone('UTC');

        // Количество новых клиентов
        $this->montnewUsersCount = User::whereBetween('created_at', [$start, $end])->count();

        // Количество трек-кодов
        $this->monttrackcodesCount = Trackcode::whereBetween('created_at', [$start, $end])->count();
        // если у тебя поле не created_at, а например received_at, то замени:
        // $trackcodesCount = Trackcode::whereBetween('received_at', [$start, $end])->count();

        // Сумма заказов за месяц
        $this->montordersSum = Order::whereBetween('created_at', [$start, $end])
            ->sum('total'); // замени 'total' на своё поле

        // Сумма затрат за месяц
        $this->montexpensesSum = Expences::whereBetween('created_at', [$start, $end])
            ->sum('total');
    }
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
