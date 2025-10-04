<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Settings extends Component
{
    public $kg_price;
    public $cube_price;
    public $address_ivu;
    public $address_dushanbe;
    public $danger_products;
    public $course_dollar;
    public $queue;

    public function mount()
    {
        // Загружаем настройки из базы
        $settings = Setting::all()->keyBy('name');

        $this->kg_price = $settings['kg_price']->content ?? '';
        $this->cube_price = $settings['cube_price']->content ?? '';
        $this->address_ivu = $settings['address_ivu']->content ?? '';
        $this->address_dushanbe = $settings['address_dushanbe']->content ?? '';
        $this->danger_products = $settings['danger_products']->content ?? '';
        $this->course_dollar = $settings['course_dollar']->content ?? '';
    }

    public function saveSettings()
    {
        $data = [
            'kg_price' => $this->kg_price,
            'cube_price' => $this->cube_price,
            'address_ivu' => $this->address_ivu,
            'address_dushanbe' => $this->address_dushanbe,
            'danger_products' => $this->danger_products,
            'course_dollar' => $this->course_dollar,
        ];

        foreach ($data as $name => $content) {
            Setting::updateOrCreate(
                ['name' => $name],
                ['content' => $content]
            );
        }

        $this->dispatch('alert', 'Настройки сохранены!');
    }
    public function render()
    {
        return view('livewire.admin.settings');
    }
}
