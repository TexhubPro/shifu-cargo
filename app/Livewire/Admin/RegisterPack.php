<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Models\Registerpack as ModelsRegisterpack;

#[Layout('components.layouts.admin')]
class RegisterPack extends Component
{
    public $weight;
    public $type;
    public $boxes;
    public $ivuweight;
    public $ivutype;
    public $ivuboxes;
    public function registerDushanbe()
    {
        ModelsRegisterpack::create([
            'sklad' => 'Душанбе',
            'weight' => $this->weight,
            'packages' => $this->boxes,
            'type' => $this->type,
        ]);
        $this->reset([
            'weight',
            'type',
            'boxes',
            'ivuweight',
            'ivutype',
            'ivuboxes',
        ]);
        $this->dispatch('alert', 'Груз успешно добавлен на склад Душанбе!');
    }
    public function registerIvu()
    {
        ModelsRegisterpack::create([
            'sklad' => 'Иву',
            'weight' => $this->ivuweight,
            'packages' => $this->ivuboxes,
            'type' => $this->ivutype,
        ]);
        $this->reset([
            'weight',
            'type',
            'boxes',
            'ivuweight',
            'ivutype',
            'ivuboxes',
        ]);
        $this->dispatch('alert', 'Груз успешно добавлен на склад Иву!');
    }
    use WithPagination;
    #[Computed]
    public function dushanbes()
    {
        $query = ModelsRegisterpack::query()->where('sklad', 'Душанбе');


        return $query->orderByDesc('created_at')
            ->paginate(50);
    }
    #[Computed]
    public function ivus()
    {
        $query = ModelsRegisterpack::query()->where('sklad', 'Иву');


        return $query->orderByDesc('created_at')
            ->paginate(50);
    }

    public function render()
    {
        return view('livewire.admin.register-pack');
    }
}
