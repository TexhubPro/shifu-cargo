<?php

namespace App\Livewire\Admin;

use App\Models\Expences;
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

    public function mount()
    {
        $this->start = Carbon::now()->startOfMonth()->toDateString();
        $this->end = Carbon::now()->endOfMonth()->toDateString();
        $this->load;
    }
    public function load()
    {

        $newClients = User::forPeriod($this->start, $this->end);
        $trackcodes = Trackcode::forPeriod($this->start, $this->end);
        $earnings = "";
        $expenses = Expences::forPeriod($this->start, $this->end);
        $delivery = "";
        $netProfit = "";
        $expensesDushanbe = "";
        $expensesIvu = "";
        $cubChina = "";
        $cubTj = "";
        $shipped = "";
        $received = "";
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
