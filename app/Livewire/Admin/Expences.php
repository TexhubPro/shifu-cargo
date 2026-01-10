<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Expences as ModelsExpences;
use App\Models\Setting;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin')]
class Expences extends Component
{
    use WithPagination;
    public $warehouse = "Склад Душанбе";
    public $amount;
    public $dollarRate;
    public $hidden = false;
    public $description;
    public $expenseCategory;
    public $employeeName;
    public $data;
    public $search = '';
    public $warehouseFilter = '';
    public $dateFrom;
    public $dateTo;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 25;
    // Правила валидации
    protected $rules = [
        'warehouse' => 'required|string',
        'amount' => 'required|numeric|min:0.01',
        'description' => 'nullable|string|max:255',
        'dollarRate' => 'nullable|numeric|min:0.01',
        'expenseCategory' => 'nullable|string|max:255',
        'employeeName' => 'nullable|string|max:255',
    ];
    public function delete($id)
    {
        ModelsExpences::find($id)->delete();
    }
    protected $messages = [
        'warehouse.required' => 'Выберите склад.',
        'amount.required' => 'Введите сумму.',
        'amount.numeric' => 'Сумма должна быть числом.',
        'amount.min' => 'Сумма должна быть больше нуля.',
        'dollarRate.required' => 'Введите курс доллара.',
        'dollarRate.numeric' => 'Курс должен быть числом.',
        'dollarRate.min' => 'Курс должен быть больше нуля.',
        'expenseCategory.required' => 'Выберите статью затрат.',
    ];
    public function updatedWarehouse()
    {
        if ($this->isCubatureWarehouse()) {
            $this->hidden = true;
            if ($this->dollarRate === null) {
                $this->dollarRate = optional(Setting::where('name', 'course_dollar')->first())->content;
            }
        } else {
            $this->hidden = false;
        }

        $this->expenseCategory = null;
        $this->employeeName = null;
    }

    // Метод добавления затрат
    public function addExpense()
    {
        $this->dollarRate = $this->normalizeDecimal($this->dollarRate);
        $rules = $this->rules;
        if ($this->isCubatureWarehouse()) {
            $rules['dollarRate'] = 'required|numeric|min:0.01';
        } elseif ($this->isWarehouseWithCategories()) {
            $rules['expenseCategory'] = 'required|string|max:255';
        }
        $this->validate($rules);

        if ($this->isCubatureWarehouse()) {
            $total = $this->dollarRate * $this->amount;
            $content = $this->warehouse;
        } else {
            if ($this->isWarehouseWithCategories()) {
                $content = $this->expenseCategory;
                if ($this->isSalaryCategory() && $this->employeeName) {
                    $content .= ' (Имя: ' . $this->employeeName . ')';
                }
            } else {
                $content = $this->description;
            }
            $total = $this->amount;
        }

        ModelsExpences::create([
            'sklad' => $this->warehouse,
            'total' => $total,
            'content' => $content,
            'data' => $this->data,
            'user_id' => auth()->id(),
        ]);

        // Сброс полей после добавления
        $this->reset(['warehouse', 'amount', 'description', 'dollarRate', 'expenseCategory', 'employeeName']);
        Flux::modals()->close();
        // Сообщение об успешном добавлении
        $this->dispatch('alert', 'Затраты успешно добавлены!');
    }
    #[Computed]
    public function expences()
    {
        return $this->baseQuery()
            ->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate($this->perPage);
    }

    #[Computed]
    public function expensesSummary(): array
    {
        [$start, $end] = $this->getStatsDateRange();
        $query = $this->baseQuery(false)->whereBetween('data', [$start, $end]);
        $total = (float) $query->sum('total');
        $count = (int) $query->count();

        return [
            'total' => $total,
            'count' => $count,
            'average' => $count ? $total / $count : 0,
            'max' => (float) $query->max('total'),
        ];
    }

    #[Computed]
    public function expensesDaily(): array
    {
        [$start, $end] = $this->getStatsDateRange();
        $days = [];
        $labels = [];
        $cursor = $start->copy();

        while ($cursor->lte($end)) {
            $key = $cursor->format('Y-m-d');
            $days[$key] = 0.0;
            $labels[] = $cursor->format('d M');
            $cursor->addDay();
        }

        $daily = $this->baseQuery(false)
            ->whereBetween('data', [$start, $end])
            ->select(DB::raw('DATE(data) as day'), DB::raw('SUM(total) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        foreach ($daily as $day => $total) {
            if (array_key_exists($day, $days)) {
                $days[$day] = (float) $total;
            }
        }

        $totals = array_values($days);

        return [
            'labels' => $labels,
            'totals' => $totals,
            'max' => $totals ? max($totals) : 0,
        ];
    }

    #[Computed]
    public function expensesByCategory(): array
    {
        [$start, $end] = $this->getStatsDateRange();
        $query = $this->baseQuery(false)->whereBetween('data', [$start, $end]);

        $items = $query
            ->select('content', DB::raw('SUM(total) as total'))
            ->groupBy('content')
            ->orderByDesc('total')
            ->limit(6)
            ->get()
            ->map(function ($row) {
                return [
                    'label' => $row->content,
                    'total' => (float) $row->total,
                ];
            })
            ->all();

        return [
            'items' => $items,
        ];
    }
    public function render()
    {
        return view('livewire.admin.expences');
    }

    protected function getSortField(): string
    {
        $allowed = ['created_at', 'total', 'sklad', 'data'];
        return in_array($this->sortField, $allowed, true) ? $this->sortField : 'created_at';
    }

    protected function getSortDirection(): string
    {
        return $this->sortDirection === 'asc' ? 'asc' : 'desc';
    }

    protected function isCubatureWarehouse(): bool
    {
        return $this->warehouse === 'Кубатура Иву' || $this->warehouse === 'Кубатура Душанбе';
    }

    protected function isWarehouseWithCategories(): bool
    {
        return $this->warehouse === 'Склад Иву' || $this->warehouse === 'Склад Душанбе';
    }

    protected function isSalaryCategory(): bool
    {
        return $this->expenseCategory
            ? Str::contains($this->expenseCategory, 'зарплата')
            : false;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedWarehouseFilter(): void
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

    public function updatedExpenseCategory(): void
    {
        if (!$this->isSalaryCategory()) {
            $this->employeeName = null;
        }
    }

    public function updatedDollarRate(): void
    {
        $this->dollarRate = $this->normalizeDecimal($this->dollarRate);
    }

    protected function baseQuery(bool $withDate = true)
    {
        $query = ModelsExpences::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('content', 'like', '%' . $this->search . '%')
                    ->orWhere('total', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->warehouseFilter)) {
            $query->where('sklad', $this->warehouseFilter);
        }

        if ($withDate) {
            if (!empty($this->dateFrom)) {
                $query->where('data', '>=', $this->dateFrom . ' 00:00:00');
            }

            if (!empty($this->dateTo)) {
                $query->where('data', '<=', $this->dateTo . ' 23:59:59');
            }
        }

        return $query;
    }

    protected function getStatsDateRange(): array
    {
        if (!empty($this->dateFrom) && !empty($this->dateTo)) {
            $start = Carbon::parse($this->dateFrom)->startOfDay();
            $end = Carbon::parse($this->dateTo)->endOfDay();
            return [$start, $end];
        }

        if (!empty($this->dateFrom)) {
            $start = Carbon::parse($this->dateFrom)->startOfDay();
            $end = $start->copy()->addDays(13)->endOfDay();
            return [$start, $end];
        }

        if (!empty($this->dateTo)) {
            $end = Carbon::parse($this->dateTo)->endOfDay();
            $start = $end->copy()->subDays(13)->startOfDay();
            return [$start, $end];
        }

        $end = Carbon::today()->endOfDay();
        $start = $end->copy()->subDays(13)->startOfDay();
        return [$start, $end];
    }

    protected function normalizeDecimal($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
        }

        return (string) $value;
    }
}
