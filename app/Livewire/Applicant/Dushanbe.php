<?php

namespace App\Livewire\Applicant;

use App\Livewire\Admin\Dushanbe as AdminDushanbe;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.applicant')]
class Dushanbe extends AdminDushanbe
{
    public function render()
    {
        return view('livewire.applicant.dushanbe');
    }
}
