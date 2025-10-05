<?php

namespace App\Livewire\Admin;

use App\Models\Faq;
use Livewire\Component;
use App\Livewire\Admin\Faqs as AdFaqs;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.admin')]
class Faqs extends Component
{
    public $faqs;
    public $question;
    public $answer;
    public function mount()
    {
        $this->faqs = Faq::all();
    }
    public function add()
    {
        Faq::create([
            'answer' => $this->answer,
            'question' => $this->question
        ]);
        Flux::modals()->close();
        return redirect()->route('admin.faqs');
    }
    public function delete($id)
    {
        Faq::find($id)->delete();
        return redirect()->route('admin.faqs');
    }
    public function render()
    {
        return view('livewire.admin.faqs');
    }
}
