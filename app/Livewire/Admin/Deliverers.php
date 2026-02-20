<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class Deliverers extends Component
{
    public $start;
    public $end;
    public $chartLabels = [];
    public $deliveryDaily = [];

    public function mount()
    {
        $this->start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->loadChart();
    }

    public function applyFilters(): void
    {
        $start = !empty($this->start)
            ? Carbon::parse($this->start)->startOfDay()
            : Carbon::now()->startOfMonth()->startOfDay();
        $end = !empty($this->end)
            ? Carbon::parse($this->end)->endOfDay()
            : Carbon::now()->endOfMonth()->endOfDay();

        if ($start->gt($end)) {
            [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
        }

        $this->start = $start->toDateString();
        $this->end = $end->toDateString();
        $this->loadChart();
    }

    public function loadChart(): void
    {
        $labels = [];
        $period = CarbonPeriod::create(
            Carbon::parse($this->start)->startOfDay(),
            Carbon::parse($this->end)->startOfDay()
        );

        foreach ($period as $date) {
            $labels[] = $date->format('Y-m-d');
        }

        $this->chartLabels = $labels;

        $deliveryRaw = Order::query()
            ->selectRaw('DATE(created_at) as day, SUM(delivery_total) as total')
            ->whereBetween('created_at', [$this->start . ' 00:00:00', $this->end . ' 23:59:59'])
            ->groupBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $this->deliveryDaily = [];
        foreach ($labels as $label) {
            $this->deliveryDaily[] = (float) ($deliveryRaw[$label] ?? 0);
        }
    }

    #[Computed]
    public function periodLabel(): string
    {
        return Carbon::parse($this->start)->format('d.m.Y') . ' — ' . Carbon::parse($this->end)->format('d.m.Y');
    }

    #[Computed]
    public function stats(): array
    {
        $orders = $this->deliveryOrders();

        return [
            'count' => $orders->count(),
            'sum' => (float) $orders->sum('delivery_total'),
            'avg' => (float) $orders->avg('delivery_total'),
        ];
    }

    #[Computed]
    public function deliverers(): array
    {
        $orders = $this->deliveryOrders();
        $grouped = $orders->groupBy('deliver_id');
        $delivererIds = $grouped->keys()
            ->filter(fn($id) => is_numeric($id))
            ->values()
            ->all();

        $users = User::query()
            ->whereIn('id', $delivererIds)
            ->get(['id', 'name', 'phone'])
            ->keyBy('id');

        $rows = [];
        foreach ($grouped as $deliverId => $items) {
            $user = $users->get((int) $deliverId);
            $name = $user?->name ?? (string) $deliverId;
            $rows[] = [
                'name' => $name !== '' ? $name : '—',
                'phone' => $user?->phone,
                'count' => $items->count(),
                'sum' => (float) $items->sum('delivery_total'),
            ];
        }

        usort($rows, fn($a, $b) => $b['sum'] <=> $a['sum']);

        return $rows;
    }

    protected function deliveryOrders()
    {
        return Order::query()
            ->whereNotNull('deliver_id')
            ->whereBetween('created_at', [$this->start . ' 00:00:00', $this->end . ' 23:59:59'])
            ->get(['id', 'deliver_id', 'delivery_total']);
    }

    public function render()
    {
        return view('livewire.admin.deliverers');
    }
}
