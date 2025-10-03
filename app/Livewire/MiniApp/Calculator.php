<?php

namespace App\Livewire\MiniApp;

use App\Models\Setting;
use Livewire\Component;

class Calculator extends Component
{
    public $weight;    // для расчёта по весу
    public $length;    // для расчёта по объёму
    public $width;
    public $height;

    public $resultWeight;
    public $resultVolume;

    private function getKgPriceTJS()
    {
        $kg_price_usd = (float) str_replace('$', '', Setting::where('name', 'kg_price')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $kg_price_usd * $course;
    }

    // Получаем цену за куб.м в сомони
    private function getCubePriceTJS()
    {
        $cube_price_usd = (float) str_replace('$', '', Setting::where('name', 'cube_price')->value('content'));
        $course = (float) Setting::where('name', 'course_dollar')->value('content');
        return $cube_price_usd * $course;
    }

    // Расчёт по весу
    public function calcWeight()
    {
        $price = $this->getKgPriceTJS();
        $this->resultWeight = 'Стоимость доставки: ' . ($this->weight * $price) . ' сомони';
    }

    // Расчёт по объёму
    public function calcVolume()
    {
        $volume = ($this->length * $this->width * $this->height) / 1000000; // м³ из см
        $price = $this->getCubePriceTJS();
        $this->resultVolume = 'Объём: ' . round($volume, 3) . ' м³, стоимость доставки: ' . round($volume * $price, 2) . ' сомони';
    }
    public function render()
    {
        return view('livewire.mini-app.calculator');
    }
}
