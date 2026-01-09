<?php

namespace App\Livewire\Applicant;

use App\Livewire\Admin\Smsbulk as AdminSmsbulk;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.applicant')]
class Smsbulk extends AdminSmsbulk
{
    public function render()
    {
        return view('livewire.applicant.smsbulk');
    }
}
