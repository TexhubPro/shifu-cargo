<?php

namespace App\Livewire\Applicant;

use App\Livewire\Admin\Chats as AdminChats;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.applicant')]
class Chats extends AdminChats
{
    public function render()
    {
        return view('livewire.applicant.chats');
    }
}
