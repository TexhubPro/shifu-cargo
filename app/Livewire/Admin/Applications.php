<?php

namespace App\Livewire\Admin;

use App\Models\Application;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.admin')]
class Applications extends Component
{
    #[Computed]
    public function orders()
    {
        $query = Application::query();

        return $query->orderByDesc('created_at')
            ->paginate(50);
    }
    public function render()
    {
        return view('livewire.admin.applications');
    }
}
