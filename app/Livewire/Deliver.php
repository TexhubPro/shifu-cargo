<?php

namespace App\Livewire;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;


#[Layout('components.layouts.empty')]
class Deliver extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $start;
    public $end;
    public $view = 'active';
    public $perPage = 9;

    public function mount(): void
    {
        $this->start = Carbon::now()->subDays(6)->toDateString();
        $this->end = Carbon::now()->toDateString();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function updatePeriod(): void
    {
        $start = Carbon::parse($this->start);
        $end = Carbon::parse($this->end);

        if ($start->gt($end)) {
            [$this->start, $this->end] = [$end->toDateString(), $start->toDateString()];
        }
    }

    public function setView(string $view): void
    {
        if (!in_array($view, ['active', 'archive'], true)) {
            return;
        }

        $this->view = $view;
        $this->resetPage('activePage');
        $this->resetPage('archivePage');
    }

    public function markDelivered(int $orderId): void
    {
        $order = Order::query()
            ->with('application')
            ->where('deliver_id', Auth::id())
            ->find($orderId);

        if (!$order) {
            $this->dispatch('alert', 'Заказ не найден.');
            return;
        }

        $order->status = 'Оплачено';
        $order->save();

        if ($order->application) {
            $order->application->status = 'Доставлено';
            $order->application->save();
        }

        $this->dispatch('alert', 'Заказ отмечен как доставленный.');
    }

    public function markReturned(int $orderId): void
    {
        $order = Order::query()
            ->with('application')
            ->where('deliver_id', Auth::id())
            ->find($orderId);

        if (!$order) {
            $this->dispatch('alert', 'Заказ не найден.');
            return;
        }

        $order->status = 'Возврат';
        $order->save();

        if ($order->application) {
            $order->application->status = 'Отменено';
            $order->application->save();
        }

        $this->dispatch('alert', 'Заказ отмечен как возврат.');
    }

    public function render()
    {
        $periodStart = Carbon::parse($this->start)->startOfDay();
        $periodEnd = Carbon::parse($this->end)->endOfDay();

        $baseQuery = Order::query()->where('deliver_id', Auth::id());
        $periodOrders = (clone $baseQuery)
            ->whereBetween('created_at', [$periodStart, $periodEnd])
            ->get(['id', 'delivery_total', 'status', 'created_at']);

        $deliveredOrders = $periodOrders->where('status', 'Оплачено');
        $returnedOrders = $periodOrders->where('status', 'Возврат');

        $totalEarned = (float) $deliveredOrders->sum('delivery_total');
        $deliveredCount = $deliveredOrders->count();
        $returnedCount = $returnedOrders->count();
        $periodTotal = $deliveredCount + $returnedCount;
        $successRate = $periodTotal > 0 ? round(($deliveredCount / $periodTotal) * 100) : 0;

        $activeCount = (clone $baseQuery)->where('status', 'Доставляется')->count();
        $archiveCount = (clone $baseQuery)->whereIn('status', ['Оплачено', 'Возврат'])->count();

        $activeOrders = collect();
        $archiveOrders = collect();

        if ($this->view === 'active') {
            $activeOrders = (clone $baseQuery)
                ->where('status', 'Доставляется')
                ->with(['user:id,name,code', 'application:id,phone,address'])
                ->orderByDesc('created_at')
                ->paginate($this->perPage, ['*'], 'activePage');
        } else {
            $archiveOrders = (clone $baseQuery)
                ->whereIn('status', ['Оплачено', 'Возврат'])
                ->with(['user:id,name,code', 'application:id,phone,address'])
                ->orderByDesc('created_at')
                ->paginate($this->perPage, ['*'], 'archivePage');
        }

        $period = CarbonPeriod::create($periodStart, $periodEnd);
        $dailyLabels = [];
        $dailyEarnings = [];
        $dailyDeliveries = [];

        $earningsByDay = $deliveredOrders->groupBy(function ($order) {
            return $order->created_at->toDateString();
        })->map(function ($items) {
            return (float) $items->sum('delivery_total');
        });

        $deliveriesByDay = $deliveredOrders->groupBy(function ($order) {
            return $order->created_at->toDateString();
        })->map(function ($items) {
            return $items->count();
        });

        foreach ($period as $date) {
            $label = $date->format('d.m');
            $key = $date->toDateString();
            $dailyLabels[] = $label;
            $dailyEarnings[] = (float) ($earningsByDay[$key] ?? 0);
            $dailyDeliveries[] = (int) ($deliveriesByDay[$key] ?? 0);
        }

        return view('livewire.deliver', [
            'activeOrders' => $activeOrders,
            'archiveOrders' => $archiveOrders,
            'activeCount' => $activeCount,
            'archiveCount' => $archiveCount,
            'totalEarned' => $totalEarned,
            'deliveredCount' => $deliveredCount,
            'returnedCount' => $returnedCount,
            'successRate' => $successRate,
            'dailyLabels' => $dailyLabels,
            'dailyEarnings' => $dailyEarnings,
            'dailyDeliveries' => $dailyDeliveries,
        ]);
    }
}
