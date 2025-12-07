<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Application;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.admin')]
class Applications extends Component
{
    use WithPagination;
    #[Computed]
    public function orders()
    {
        $query = Application::query();

        return $query->orderByDesc('created_at')
            ->paginate(50);
    }
    public function delete($id)
    {
        Application::find($id)->delete();
    }
    public function cleanInvalid()
    {
        Application::where('status', 'Отменено')->delete();

        Application::where(function ($query) {
            $query->whereNull('phone')
                ->orWhere('phone', '')
                ->orWhereRaw("phone REGEXP '[^0-9+]'")
                ->orWhereRaw('LENGTH(phone) < 7')
                ->orWhereNull('address')
                ->orWhere('address', '')
                ->orWhereRaw('LENGTH(address) < 8')
                ->orWhereRaw("address REGEXP '^[0-9]+$'");
        })->delete();

        $this->dispatch('alert', 'Неверные заявки удалены.');
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.admin.applications');
    }
}
