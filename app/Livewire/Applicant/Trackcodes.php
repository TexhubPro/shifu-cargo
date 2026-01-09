<?php

namespace App\Livewire\Applicant;

use App\Livewire\Admin\Trackcodes as AdminTrackcodes;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.applicant')]
class Trackcodes extends AdminTrackcodes
{
    public function render()
    {
        return view('livewire.applicant.trackcodes');
    }
}
