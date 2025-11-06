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

    // Правила валидации
    protected $rules = [
        'warehouse' => 'required|string',
        'amount' => 'required|numeric|min:0.01',
        'description' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'warehouse.required' => 'Выберите склад.',
        'amount.required' => 'Введите сумму.',
        'amount.numeric' => 'Сумма должна быть числом.',
        'amount.min' => 'Сумма должна быть больше нуля.',
    ];
    public function updatedWarehouse()
    {
        if ($this->warehouse == 'Кубатура') {
            $this->hidden = true;
        } else {
            $this->hidden = false;
        }
    }

    // Метод добавления затрат
    public function addExpense()
    {
        $this->validate();
        if ($this->warehouse == 'Кубатура') {
            $course = Setting::where('name', 'course_dollar')->first();
            $total = $course->content * $this->amount;
            $content = "Кубатура";
        } else {
            $content = $this->description;
            $total = $this->amount;
        }

        ModelsExpences::create([
            'sklad' => $this->warehouse,
            'total' => $total,
            'content' => $content,
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


        return $query->orderByDesc('created_at')
            ->paginate(50);
    }
    public function render()
    {
        return view('livewire.admin.expences');
    }
}
