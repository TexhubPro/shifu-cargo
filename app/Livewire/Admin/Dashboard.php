<?php

namespace App\Livewire\Admin;

use App\Models\Expences;
use App\Models\Order;
use App\Models\Registerpack;
use App\Models\Trackcode;
use App\Models\User;
use Carbon\Carbon;
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

    public function mount()
    {
        $this->start = Carbon::now()->startOfMonth()->toDateString();
        $this->end = Carbon::now()->endOfMonth()->toDateString();
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
