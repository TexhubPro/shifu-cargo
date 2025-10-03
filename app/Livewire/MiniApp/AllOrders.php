<?php

namespace App\Livewire\MiniApp;

use Livewire\Component;
use App\Models\Trackcode;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AllOrders extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap'; // или 'tailwind'

    public function render()
    {
        $orders = Trackcode::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->paginate(50);

        return view('livewire.mini-app.all-orders', [
            'orders' => $orders,
        ]);
    }
}
