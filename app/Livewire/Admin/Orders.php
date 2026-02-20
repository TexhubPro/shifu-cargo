<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class Orders extends Component
{
    use WithPagination;
    public $searchCode = '';
    public $searchPhone = '';
    public $dateFrom;
    public $dateTo;
    public $minTotal;
    public $maxTotal;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 100;
    public $onlyApplicationsWithPhoto = false;
    public $orderToDelete = null;
    public $orderToDeleteClient = null;
    public $orderToDeleteTotal = null;
    #[Computed]
    public function orders()
    {
        $query = Order::query()
            ->with('user:id,code,phone')
            ->select(['id', 'user_id', 'weight', 'cube', 'subtotal', 'discount', 'total', 'created_at']);

        if (!empty($this->searchCode)) {
            $query->whereHas('user', function ($q) {
                $q->where('code', 'like', '%' . $this->searchCode . '%');
            });
        }

        if (!empty($this->searchPhone)) {
            $query->whereHas('user', function ($q) {
                $q->where('phone', 'like', '%' . $this->searchPhone . '%');
            });
        }

        if (!empty($this->dateFrom)) {
            $query->where('created_at', '>=', $this->dateFrom . ' 00:00:00');
        }

        if (!empty($this->dateTo)) {
            $query->where('created_at', '<=', $this->dateTo . ' 23:59:59');
        }

        if (!empty($this->minTotal)) {
            $query->where('total', '>=', $this->minTotal);
        }

        if (!empty($this->maxTotal)) {
            $query->where('total', '<=', $this->maxTotal);
        }

        if ($this->onlyApplicationsWithPhoto) {
            $query->whereNotNull('application_id')
                ->whereNotNull('photo_report_path')
                ->where('photo_report_path', '!=', '');
        }

        return $query->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate($this->perPage);
    }

    #[Computed]
    public function monthStats(): array
    {
        $query = Order::query();
        $fromDate = null;
        $toDate = null;

        if (!empty($this->dateFrom)) {
            $fromDate = Carbon::parse($this->dateFrom);
            $query->where('created_at', '>=', $fromDate->copy()->startOfDay());
        }

        if (!empty($this->dateTo)) {
            $toDate = Carbon::parse($this->dateTo);
            $query->where('created_at', '<=', $toDate->copy()->endOfDay());
        }

        if ($fromDate === null && $toDate === null) {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $query->whereBetween('created_at', [$start, $end]);
            $label = 'Месяц ' . $start->format('m.Y');
        } elseif ($fromDate !== null && $toDate !== null) {
            $label = 'Период ' . $fromDate->format('d.m.Y') . ' — ' . $toDate->format('d.m.Y');
        } elseif ($fromDate !== null) {
            $label = 'С ' . $fromDate->format('d.m.Y');
        } else {
            $label = 'До ' . $toDate->format('d.m.Y');
        }

        $count = (clone $query)->count();
        $sum = (clone $query)->sum('total');
        $avg = $count > 0 ? round($sum / $count, 2) : 0;
        $weight = (clone $query)->sum('weight');

        return [
            'count' => $count,
            'sum' => $sum,
            'avg' => $avg,
            'weight' => $weight,
            'label' => $label,
        ];
    }
    public function confirmDelete(int $id): void
    {
        $order = Order::query()
            ->with('user:id,code')
            ->select(['id', 'user_id', 'total'])
            ->find($id);

        if (!$order) {
            $this->clearDeleteSelection();
            return;
        }

        $this->orderToDelete = $order->id;
        $this->orderToDeleteClient = $order->user->code ?? (string) $order->user_id;
        $this->orderToDeleteTotal = (float) $order->total;
    }

    public function deleteSelected(): void
    {
        if ($this->orderToDelete === null) {
            return;
        }

        $order = Order::find($this->orderToDelete);
        if ($order) {
            $order->delete();
        }

        $this->clearDeleteSelection();
        $this->resetPage();
    }

    public function clearDeleteSelection(): void
    {
        $this->orderToDelete = null;
        $this->orderToDeleteClient = null;
        $this->orderToDeleteTotal = null;
    }

    public function applyFilters(): void
    {
        $this->resetPage();
    }

    protected function getSortField(): string
    {
        $allowed = ['created_at', 'total', 'weight', 'cube', 'subtotal', 'discount'];
        return in_array($this->sortField, $allowed, true) ? $this->sortField : 'created_at';
    }

    protected function getSortDirection(): string
    {
        return $this->sortDirection === 'asc' ? 'asc' : 'desc';
    }

    public function updatedSearchCode(): void
    {
        $this->resetPage();
    }

    public function updatedSearchPhone(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function updatedMinTotal(): void
    {
        $this->resetPage();
    }

    public function updatedMaxTotal(): void
    {
        $this->resetPage();
    }

    public function updatedSortField(): void
    {
        $this->resetPage();
    }

    public function updatedSortDirection(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }
    public function updatedOnlyApplicationsWithPhoto(): void
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.admin.orders');
    }
}
