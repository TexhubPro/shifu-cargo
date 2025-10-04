<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dushanbe extends Component
{
    use WithFileUploads;
    public $excelFilewriteOffItem;
    public $excelFile;
    public $flightDates;
    public function writeOffItem()
    {
        //
    }
    public function importExcel()
    {
        //
    }
    public function render()
    {
        return view('livewire.admin.dushanbe');
    }
}
