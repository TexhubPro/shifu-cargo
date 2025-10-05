<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Trackcode;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.admin')]

class Trackcodes extends Component
{
    public $user_code;
    public $search = null;
    #[Computed]
    public function trackcodes()
    {
        $query = Trackcode::query();

        if (!empty($this->search)) {
            $query->where('code', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->user_code)) {
            $query->where('user_id', $this->user_id);
        }

        return $query->orderByDesc('created_at')
            ->paginate(50);
    }
    public function search_form() {}
    public function render()
    {
        return view('livewire.admin.trackcodes');
    }
}
