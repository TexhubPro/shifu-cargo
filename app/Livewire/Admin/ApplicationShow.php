<?php

namespace App\Livewire\Admin;

use App\Models\Application;
use App\Models\Trackcode;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class ApplicationShow extends Component
{
    public Application $application;
    public $trackcodes = [];

    public function mount(Application $application): void
    {
        $this->application = Application::query()
            ->with(['user:id,code,name,phone,sex', 'order.deliver:id,name,phone'])
            ->findOrFail($application->id);

        if ($this->application->order) {
            $this->trackcodes = Trackcode::query()
                ->where('order_id', $this->application->order->id)
                ->orderBy('id')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.admin.application-show');
    }
}
