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
    public $perPage = 25;
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

        return $query->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate($this->perPage);
    }

    #[Computed]
    public function monthStats(): array
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        $query = Order::query()
            ->whereBetween('created_at', [$start, $end]);

        $count = (clone $query)->count();
        $sum = (clone $query)->sum('total');
        $avg = $count > 0 ? round($sum / $count, 2) : 0;
        $weight = (clone $query)->sum('weight');

        return [
            'count' => $count,
            'sum' => $sum,
            'avg' => $avg,
            'weight' => $weight,
            'label' => $start->format('m.Y'),
        ];
    }
    public function delete($id)
    {
        Order::find($id)->delete();
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
    public function render()
    {
        return view('livewire.admin.orders');
    }
}
