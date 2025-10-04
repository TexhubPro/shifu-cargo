<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public array $data = [
        ['date' => '2025-10-08', 'visitors' => 1532],
        ['date' => '2025-10-07', 'visitors' => 259],
        ['date' => '2025-10-06', 'visitors' => 269],
        ['date' => '2025-10-05', 'visitors' => 555],
        ['date' => '2025-10-04', 'visitors' => 3445],
        ['date' => '2025-10-03', 'visitors' => 434],
        ['date' => '2025-10-02', 'visitors' => 34],
        ['date' => '2025-10-01', 'visitors' => 4566],
    ];
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
