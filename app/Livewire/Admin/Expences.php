<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Expences as ModelsExpences;
use App\Models\Setting;
use Flux\Flux;

#[Layout('components.layouts.admin')]
class Expences extends Component
{
    use WithPagination;
    public $warehouse = "Склад Душанбе";
    public $amount;
    public $hidden = false;
    public $description;
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
    ];
    public function updatedWarehouse()
    {
        if ($this->warehouse == 'Кубатура Иву' || $this->warehouse == 'Кубатура Душанбе') {
            $this->hidden = true;
        } else {
            $this->hidden = false;
        }
    }

    // Метод добавления затрат
    public function addExpense()
    {
        $this->validate();
        if ($this->warehouse == 'Кубатура Иву' || $this->warehouse == 'Кубатура Душанбе') {
            $course = Setting::where('name', 'course_dollar')->first();
            $total = $course->content * $this->amount;
            $content = $this->warehouse;
        } else {
            $content = $this->description;
            $total = $this->amount;
        }

        ModelsExpences::create([
            'sklad' => $this->warehouse,
            'total' => $total,
            'content' => $content,
            'data' => $this->data
        ]);

        // Сброс полей после добавления
        $this->reset(['warehouse', 'amount', 'description']);
        Flux::modals()->close();
        // Сообщение об успешном добавлении
        $this->dispatch('alert', 'Затраты успешно добавлены!');
    }
    #[Computed]
    public function expences()
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

        if (!empty($this->dateFrom)) {
            $query->where('data', '>=', $this->dateFrom . ' 00:00:00');
        }

        if (!empty($this->dateTo)) {
            $query->where('data', '<=', $this->dateTo . ' 23:59:59');
        }

        return $query->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate($this->perPage);
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
}
