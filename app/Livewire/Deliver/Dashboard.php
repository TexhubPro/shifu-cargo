<?php

namespace App\Livewire\Deliver;

use App\Models\Order;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.empty')]
class Dashboard extends Component
{
    public $start;
    public $end;

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

    protected function baseQuery()
    {
        $user = Auth::user();

        return Order::query()->where(function ($query) use ($user) {
            $query->where('deliver_id', $user->id)
                ->orWhere('deliver_id', $user->name);
        });
    }

    public function render()
    {
        $periodStart = Carbon::parse($this->start)->startOfDay();
        $periodEnd = Carbon::parse($this->end)->endOfDay();

        $periodOrders = (clone $this->baseQuery())
            ->whereBetween('created_at', [$periodStart, $periodEnd])
            ->get(['id', 'delivery_total', 'status', 'created_at']);

        $deliveredOrders = $periodOrders->where('status', 'Оплачено');
        $returnedOrders = $periodOrders->where('status', 'Возврат');

        $totalEarned = (float) $deliveredOrders->sum('delivery_total');
        $deliveredCount = $deliveredOrders->count();
        $returnedCount = $returnedOrders->count();
        $periodTotal = $deliveredCount + $returnedCount;
        $successRate = $periodTotal > 0 ? round(($deliveredCount / $periodTotal) * 100) : 0;

        $activeCount = (clone $this->baseQuery())->where('status', 'Доставляется')->count();
        $archiveCount = (clone $this->baseQuery())->whereIn('status', ['Оплачено', 'Возврат'])->count();

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

        return view('livewire.deliver.dashboard', [
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
