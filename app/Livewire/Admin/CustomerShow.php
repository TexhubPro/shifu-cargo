<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Trackcode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class CustomerShow extends Component
{
    public User $user;
    public $ordersByDay;
    public $maxOrders;
    public $ordersTotal;
    public $ordersSum;
    public $avgOrder;
    public $trackcodesCount;
    public $lastOrderAt;
    public $ordersByStatus;
    public $recentOrders;
    public $recentTrackcodes;

    public function mount(User $user): void
    {
        $this->user = User::query()
            ->select(['id', 'code', 'name', 'phone', 'sex', 'created_at'])
            ->findOrFail($user->id);

        $ordersQuery = Order::query()->where('user_id', $this->user->id);
        $this->ordersTotal = $ordersQuery->count();
        $this->ordersSum = (float) $ordersQuery->sum('total');
        $this->avgOrder = $this->ordersTotal > 0 ? $this->ordersSum / $this->ordersTotal : 0;

        $this->trackcodesCount = Trackcode::query()->where('user_id', $this->user->id)->count();
        $this->lastOrderAt = Order::query()
            ->where('user_id', $this->user->id)
            ->latest()
            ->value('created_at');

        $days = collect(range(6, 0))
            ->map(fn ($offset) => Carbon::now()->subDays($offset))
            ->values();

        $this->ordersByDay = $days->map(function ($day) {
            return [
                'label' => $day->format('d.m'),
                'value' => Order::where('user_id', $this->user->id)
                    ->whereDate('created_at', $day->toDateString())
                    ->count(),
            ];
        });
        $this->maxOrders = max(1, (int) $this->ordersByDay->max('value'));

        $this->ordersByStatus = Order::query()
            ->select('status', DB::raw('count(*) as total'))
            ->where('user_id', $this->user->id)
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $this->recentOrders = Order::query()
            ->where('user_id', $this->user->id)
            ->latest()
            ->limit(5)
            ->get();

        $this->recentTrackcodes = Trackcode::query()
            ->where('user_id', $this->user->id)
            ->latest()
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.customer-show');
    }
}
