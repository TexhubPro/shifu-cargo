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
    public function render()
    {
        return view('livewire.admin.applications');
    }
}
