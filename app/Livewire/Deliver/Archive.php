<?php

namespace App\Livewire\Deliver;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.empty')]
class Archive extends Component
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

    public function render()
    {
        $activeCount = (clone $this->baseQuery())->where('status', 'Доставляется')->count();
        $archiveCount = (clone $this->baseQuery())->whereIn('status', ['Оплачено', 'Возврат'])->count();

        $orders = (clone $this->baseQuery())
            ->whereIn('status', ['Оплачено', 'Возврат'])
            ->with(['user:id,name,code', 'application:id,phone,address'])
            ->orderByDesc('created_at')
            ->paginate($this->perPage);

        return view('livewire.deliver.archive', [
            'orders' => $orders,
            'activeCount' => $activeCount,
            'archiveCount' => $archiveCount,
        ]);
    }
}
