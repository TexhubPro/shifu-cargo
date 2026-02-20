<?php

namespace App\Livewire\Admin;

use App\Models\Expences;
use App\Models\Order;
use App\Models\Registerpack;
use App\Models\Trackcode;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\Attributes\Computed;
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
    public $applicationsTotal;
    public $cashdeskTotal;
    public $deliveryOnlyTotal;
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
    public $warehouseId = '';

    public function mount()
    {
        $this->end = Carbon::today()->toDateString();
        $this->start = Carbon::today()->subDays(3)->toDateString();
        $this->load();
    }

    #[Computed]
    public function warehouses()
    {
        return Warehouse::query()
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function load()
    {
        $start = Carbon::parse($this->start)->startOfDay();
        $end = Carbon::parse($this->end)->endOfDay();

        $warehouseId = $this->warehouseId !== '' ? (int) $this->warehouseId : null;
        if ($warehouseId !== null) {
            $warehouse = Warehouse::query()->select(['id', 'name'])->find($warehouseId);
            if (!$warehouse) {
                $warehouseId = null;
                $this->warehouseId = '';
            }
        }

        $this->newClients = User::forPeriod($start->toDateString(), $end->toDateString());
        $this->trackcodes = Trackcode::forPeriod($start->toDateString(), $end->toDateString());

        $ordersBaseQuery = Order::query()
            ->whereBetween('created_at', [$start, $end]);
        $this->applyWarehouseFilterToOrders($ordersBaseQuery, $warehouseId);

        $this->earnings = (clone $ordersBaseQuery)->get();
        $this->delivery = (clone $ordersBaseQuery)->get();
        $this->applicationsTotal = (clone $ordersBaseQuery)
            ->whereNotNull('application_id')
            ->sum('total');
        $this->cashdeskTotal = (clone $ordersBaseQuery)
            ->whereNull('application_id')
            ->sum('total');
        $this->deliveryOnlyTotal = (clone $ordersBaseQuery)
            ->sum('delivery_total');

        $expensesBaseQuery = Expences::query()
            ->whereBetween('data', [$start, $end]);
        $this->applyWarehouseFilterToExpenses($expensesBaseQuery, $warehouseId);

        $this->expenses = (clone $expensesBaseQuery)->get();
        $this->netProfit = $this->earnings->sum('total') - $this->expenses->sum('total');
        $this->expensesDushanbe = (clone $expensesBaseQuery)
            ->where('sklad', 'Склад Душанбе')
            ->get();
        $this->expensesIvu = (clone $expensesBaseQuery)
            ->where('sklad', 'Склад Иву')
            ->get();
        $this->cubChina = (clone $expensesBaseQuery)
            ->where('sklad', 'Кубатура Иву')
            ->get();
        $this->cubTj = (clone $expensesBaseQuery)
            ->where('sklad', 'Кубатура Душанбе')
            ->get();

        $this->shipped = Registerpack::shipped($start->toDateString(), $end->toDateString());
        $this->received = Registerpack::received($start->toDateString(), $end->toDateString());

        $labels = [];
        $period = CarbonPeriod::create(
            $start->copy()->startOfDay(),
            $end->copy()->startOfDay()
        );

        foreach ($period as $date) {
            $labels[] = $date->format('Y-m-d');
        }

        $this->chartLabels = $labels;

        $trackcodesRaw = Trackcode::query()
            ->selectRaw('DATE(china) as day, COUNT(*) as total')
            ->whereBetween('china', [$start, $end])
            ->where('status', 'Получено в Иву')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $ordersRawQuery = Order::query()
            ->selectRaw('DATE(created_at) as day, SUM(total) as total')
            ->whereBetween('created_at', [$start, $end]);
        $this->applyWarehouseFilterToOrders($ordersRawQuery, $warehouseId);

        $ordersRaw = $ordersRawQuery
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $expensesRawQuery = Expences::query()
            ->selectRaw('DATE(data) as day, SUM(total) as total')
            ->whereBetween('data', [$start, $end]);
        $this->applyWarehouseFilterToExpenses($expensesRawQuery, $warehouseId);

        $expensesRaw = $expensesRawQuery
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $clientsRaw = User::query()
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->whereBetween('created_at', [$start, $end])
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

    protected function applyWarehouseFilterToOrders(Builder $query, ?int $warehouseId): void
    {
        if ($warehouseId !== null) {
            $query->where('warehouse_id', $warehouseId);
        }
    }

    protected function applyWarehouseFilterToExpenses(Builder $query, ?int $warehouseId): void
    {
        if ($warehouseId !== null) {
            $query->where('warehouse_id', $warehouseId);
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
