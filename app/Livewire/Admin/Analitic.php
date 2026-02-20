<?php

namespace App\Livewire\Admin;

use App\Exports\ClientsExport;
use App\Exports\ExpencesExport;
use App\Exports\ExpensesCubatureExport;
use App\Exports\ExpensesDushanbeExport;
use App\Exports\ExpensesIvuExport;
use App\Exports\GeneralExport;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.admin')]
class Analitic extends Component
{
    public $from;
    public $to;

    public function mount(): void
    {
        $this->to = Carbon::today()->toDateString();
        $this->from = Carbon::today()->subDays(3)->toDateString();
    }

    public function applyFilters(): void
    {
        // The date range is applied via deferred bindings on button click.
    }

    public function downloadReportOrders()
    {
        $fileName = 'orders_' . ($this->from ?? 'all') . '_' . ($this->to ?? 'all') . '.xlsx';

        return Excel::download(new OrdersExport($this->from, $this->to), $fileName);
    }
    public function downloadReportExpensesAll()
    {
        $fileName = 'expences_' . ($this->from ?? 'all') . '_' . ($this->to ?? 'all') . '.xlsx';

        return Excel::download(new ExpencesExport($this->from, $this->to), $fileName);
    }
    public function downloadReportExpensesDushanbe()
    {
        $fileName = 'expenses_dushanbe_' . ($this->from ?? 'all') . '_' . ($this->to ?? 'all') . '.xlsx';
        return Excel::download(new ExpensesDushanbeExport($this->from, $this->to), $fileName);
    }

    public function downloadReportExpensesIvu()
    {
        $fileName = 'expenses_ivu_' . ($this->from ?? 'all') . '_' . ($this->to ?? 'all') . '.xlsx';
        return Excel::download(new ExpensesIvuExport($this->from, $this->to), $fileName);
    }

    public function downloadReportExpensesCubature()
    {
        $fileName = 'expenses_cubature_' . ($this->from ?? 'all') . '_' . ($this->to ?? 'all') . '.xlsx';
        return Excel::download(new ExpensesCubatureExport($this->from, $this->to), $fileName);
    }

    public function downloadReportClients()
    {
        $fileName = 'clients_' . ($this->from ?? 'all') . '_' . ($this->to ?? 'all') . '.xlsx';
        return Excel::download(new ClientsExport($this->from, $this->to), $fileName);
    }

    public function downloadReportGeneral()
    {
        $fileName = 'general_' . ($this->from ?? 'all') . '_' . ($this->to ?? 'all') . '.xlsx';
        return Excel::download(new GeneralExport($this->from, $this->to), $fileName);
    }
    public function render()
    {
        return view('livewire.admin.analitic');
    }
}
