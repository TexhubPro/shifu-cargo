<?php

namespace App\Livewire\Applicant;

use App\Livewire\Admin\Customers as AdminCustomers;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.applicant')]
class Customers extends AdminCustomers
{
    public function render()
    {
        return view('livewire.applicant.customers');
    }
}
