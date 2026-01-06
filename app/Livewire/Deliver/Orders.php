<?php

namespace App\Livewire\Deliver;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.empty')]
class Orders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $perPage = 9;

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    protected function baseQuery()
    {
        $user = Auth::user();

        return Order::query()->where(function ($query) use ($user) {
            $query->where('deliver_id', $user->id)
                ->orWhere('deliver_id', $user->name);
        });
    }

    public function markDelivered(int $orderId): void
    {
        $order = (clone $this->baseQuery())
            ->with('application')
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
        $order = (clone $this->baseQuery())
            ->with('application')
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
        $activeCount = (clone $this->baseQuery())->where('status', 'Доставляется')->count();
        $archiveCount = (clone $this->baseQuery())->whereIn('status', ['Оплачено', 'Возврат'])->count();

        $orders = (clone $this->baseQuery())
            ->where('status', 'Доставляется')
            ->with(['user:id,name,code', 'application:id,phone,address'])
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.deliver.orders', [
            'orders' => $orders,
            'activeCount' => $activeCount,
            'archiveCount' => $archiveCount,
        ]);
    }
}
