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
    public $type = "мелкий";
    public $boxes;
    public $ivuweight;
    public $ivutype = "мелкий";
    public $ivuboxes;
    public $cube;
    public $ivucube;
    public $data;
    public $ivudata;
    public $searchDushanbe = '';
    public $searchIvu = '';
    public $typeFilterDushanbe = '';
    public $typeFilterIvu = '';
    public $dateFromDushanbe;
    public $dateToDushanbe;
    public $dateFromIvu;
    public $dateToIvu;
    public $sortFieldDushanbe = 'created_at';
    public $sortDirectionDushanbe = 'desc';
    public $sortFieldIvu = 'created_at';
    public $sortDirectionIvu = 'desc';
    public function registerDushanbe()
    {
        ModelsRegisterpack::create([
            'sklad' => 'Душанбе',
            'weight' => $this->weight ?? 0,
            'packages' => $this->boxes ?? 0,
            'type' => $this->type,
            'cube' => $this->cube ?? 0,
            'data' => $this->data,
        ]);
        $this->reset([
            'weight',
            'type',
            'boxes',
            'ivuweight',
            'ivutype',
            'ivuboxes',
            'data',
            'ivudata',
            'cube',
            'ivucube',
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
            'cube' => $this->ivucube ?? 0,
            'data' => $this->ivudata,
        ]);
        $this->reset([
            'weight',
            'type',
            'boxes',
            'ivuweight',
            'ivutype',
            'ivuboxes',
            'data',
            'ivudata',
            'cube',
            'ivucube',
        ]);
        $this->dispatch('alert', 'Груз успешно добавлен на склад Иву!');
    }
    use WithPagination;
    #[Computed]
    public function dushanbes()
    {
        $query = ModelsRegisterpack::query()->where('sklad', 'Душанбе');

        if (!empty($this->searchDushanbe)) {
            $search = $this->searchDushanbe;
            $query->where(function ($q) use ($search) {
                $q->where('type', 'like', '%' . $search . '%')
                    ->orWhere('packages', 'like', '%' . $search . '%')
                    ->orWhere('weight', 'like', '%' . $search . '%')
                    ->orWhere('cube', 'like', '%' . $search . '%');
            });
        }

        if (!empty($this->typeFilterDushanbe)) {
            $query->where('type', $this->typeFilterDushanbe);
        }

        if (!empty($this->dateFromDushanbe)) {
            $query->where('data', '>=', $this->dateFromDushanbe . ' 00:00:00');
        }

        if (!empty($this->dateToDushanbe)) {
            $query->where('data', '<=', $this->dateToDushanbe . ' 23:59:59');
        }

        return $query->orderBy($this->getSortFieldDushanbe(), $this->getSortDirectionDushanbe())
            ->paginate(50, ['*'], 'dushanbePage');
    }
    #[Computed]
    public function ivus()
    {
        $query = ModelsRegisterpack::query()->where('sklad', 'Иву');

        if (!empty($this->searchIvu)) {
            $search = $this->searchIvu;
            $query->where(function ($q) use ($search) {
                $q->where('type', 'like', '%' . $search . '%')
                    ->orWhere('packages', 'like', '%' . $search . '%')
                    ->orWhere('weight', 'like', '%' . $search . '%')
                    ->orWhere('cube', 'like', '%' . $search . '%');
            });
        }

        if (!empty($this->typeFilterIvu)) {
            $query->where('type', $this->typeFilterIvu);
        }

        if (!empty($this->dateFromIvu)) {
            $query->where('data', '>=', $this->dateFromIvu . ' 00:00:00');
        }

        if (!empty($this->dateToIvu)) {
            $query->where('data', '<=', $this->dateToIvu . ' 23:59:59');
        }

        return $query->orderBy($this->getSortFieldIvu(), $this->getSortDirectionIvu())
            ->paginate(50, ['*'], 'ivuPage');
    }

    protected function getSortFieldDushanbe(): string
    {
        $allowed = ['created_at', 'data', 'weight', 'cube', 'packages', 'type'];
        return in_array($this->sortFieldDushanbe, $allowed, true) ? $this->sortFieldDushanbe : 'created_at';
    }

    protected function getSortDirectionDushanbe(): string
    {
        return $this->sortDirectionDushanbe === 'asc' ? 'asc' : 'desc';
    }

    protected function getSortFieldIvu(): string
    {
        $allowed = ['created_at', 'data', 'weight', 'cube', 'packages', 'type'];
        return in_array($this->sortFieldIvu, $allowed, true) ? $this->sortFieldIvu : 'created_at';
    }

    protected function getSortDirectionIvu(): string
    {
        return $this->sortDirectionIvu === 'asc' ? 'asc' : 'desc';
    }

    public function updatedSearchDushanbe(): void
    {
        $this->resetPage('dushanbePage');
    }

    public function updatedSearchIvu(): void
    {
        $this->resetPage('ivuPage');
    }

    public function updatedTypeFilterDushanbe(): void
    {
        $this->resetPage('dushanbePage');
    }

    public function updatedTypeFilterIvu(): void
    {
        $this->resetPage('ivuPage');
    }

    public function updatedDateFromDushanbe(): void
    {
        $this->resetPage('dushanbePage');
    }

    public function updatedDateToDushanbe(): void
    {
        $this->resetPage('dushanbePage');
    }

    public function updatedDateFromIvu(): void
    {
        $this->resetPage('ivuPage');
    }

    public function updatedDateToIvu(): void
    {
        $this->resetPage('ivuPage');
    }

    public function updatedSortFieldDushanbe(): void
    {
        $this->resetPage('dushanbePage');
    }

    public function updatedSortDirectionDushanbe(): void
    {
        $this->resetPage('dushanbePage');
    }

    public function updatedSortFieldIvu(): void
    {
        $this->resetPage('ivuPage');
    }

    public function updatedSortDirectionIvu(): void
    {
        $this->resetPage('ivuPage');
    }
    public function delete($id)
    {
        ModelsRegisterpack::find($id)->delete();
    }
    public function render()
    {
        return view('livewire.admin.register-pack');
    }
}
