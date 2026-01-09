<?php

namespace App\Livewire\Applicant;

use App\Livewire\Admin\China as AdminChina;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.applicant')]
class China extends AdminChina
{
    public function render()
    {
        return view('livewire.applicant.china');
    }
}
