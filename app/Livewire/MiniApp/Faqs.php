<?php

namespace App\Livewire\MiniApp;

use App\Models\Faq;
use Livewire\Component;

class Faqs extends Component
{
    public $faqs;

    public function mount()
    {
        $this->faqs = Faq::all();
    }
    public function render()
    {
        return view('livewire.mini-app.faqs');
    }
}
