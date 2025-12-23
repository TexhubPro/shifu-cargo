<?php

namespace App\Livewire\Admin;

use App\Models\Expences;
use App\Models\Order;
use App\Models\Registerpack;
use App\Models\Trackcode;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{

    public $start;
    public $end;
    public $newClients;
    public $trackcodes;
    public $earnings;
    public $expenses;
    public $delivery;
    public $netProfit;
    public $expensesDushanbe;
    public $expensesIvu;
    public $cubChina;
    public $cubTj;
    public $shipped;
    public $received;
    public $chartLabels = [];
    public $trackcodesDaily = [];
    public $ordersDaily = [];
    public $expensesDaily = [];
    public $clientsDaily = [];

    public function mount()
    {
        $this->end = Carbon::now(); // сегодня
        $this->start = Carbon::now()->subDays(3); // 7 дней назад
        $this->load();
    }
    public function load()
    {
        $this->newClients = User::forPeriod($this->start, $this->end);
        $this->trackcodes = Trackcode::forPeriod($this->start, $this->end);
        $this->earnings = Order::forPeriod($this->start, $this->end);
        $this->expenses = Expences::forPeriodAll($this->start, $this->end);
        $this->delivery = Order::forPeriod($this->start, $this->end);
        $this->netProfit = Order::forPeriod($this->start, $this->end)->sum('total') - $this->expenses->sum('total');
        $this->expensesDushanbe = Expences::forPeriodDushanbe($this->start, $this->end);
        $this->expensesIvu = Expences::forPeriodIvu($this->start, $this->end);
        $this->cubChina = Expences::forPeriodCubeIvu($this->start, $this->end);
        $this->cubTj = Expences::forPeriodCubeDushanbe($this->start, $this->end);;
        $this->shipped = Registerpack::shipped($this->start, $this->end);
        $this->received = RegisterPack::received($this->start, $this->end);

        $labels = [];
        $period = CarbonPeriod::create(
            Carbon::parse($this->start)->startOfDay(),
            Carbon::parse($this->end)->startOfDay()
        );

        foreach ($period as $date) {
            $labels[] = $date->format('Y-m-d');
        }

        $this->chartLabels = $labels;

        $trackcodesRaw = Trackcode::query()
            ->selectRaw('DATE(china) as day, COUNT(*) as total')
            ->whereBetween('china', [$this->start . ' 00:00:00', $this->end . ' 23:59:59'])
            ->where('status', 'Получено в Иву')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $ordersRaw = Order::query()
            ->selectRaw('DATE(created_at) as day, SUM(total) as total')
            ->whereBetween('created_at', [$this->start . ' 00:00:00', $this->end . ' 23:59:59'])
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $expensesRaw = Expences::query()
            ->selectRaw('DATE(data) as day, SUM(total) as total')
            ->whereBetween('data', [$this->start . ' 00:00:00', $this->end . ' 23:59:59'])
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $clientsRaw = User::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->whereBetween('created_at', [$this->start . ' 00:00:00', $this->end . ' 23:59:59'])
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $this->trackcodesDaily = [];
        $this->ordersDaily = [];
        $this->expensesDaily = [];
        $this->clientsDaily = [];

        foreach ($labels as $label) {
            $this->trackcodesDaily[] = (int) ($trackcodesRaw[$label] ?? 0);
            $this->ordersDaily[] = (float) ($ordersRaw[$label] ?? 0);
            $this->expensesDaily[] = (float) ($expensesRaw[$label] ?? 0);
            $this->clientsDaily[] = (int) ($clientsRaw[$label] ?? 0);
        }
    }
    public function update()
    {
        $this->load();
    }
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
