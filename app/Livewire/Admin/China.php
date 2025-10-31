<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use Livewire\Component;
use App\Texhub\Telegram;
use App\Models\Trackcode;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Jobs\SendTrackNotification;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.admin')]
class China extends Component
{
    use WithFileUploads;
    public $excelfile;
    public $singleTrack;
    public function addSingleTrack()
    {
        $trackcode = Trackcode::where('code', $this->singleTrack)->first();
        if ($trackcode) {
            $trackcode->china = Carbon::now();
            $trackcode->status = "Получено в Иву";
            $trackcode->save();
            if ($trackcode->user_id) {
                $sms = new Telegram();
                $sms->sms_send_ivu($trackcode->user_id, $trackcode);
            }
        } else {
            Trackcode::create([
                'code' => $this->singleTrack,
                'china' => Carbon::now(),
                'status' => "Получено в Иву"
            ]);
        }
        $this->dispatch('alert', 'Данные успешно загружены!');
        $this->reset(['singleTrack', 'excelfile']);
    }
    public function importExcel()
    {
        $this->validate([
            'excelfile' => 'required|file|mimes:xlsx,csv',
        ]);

        // Читаем массив из Excel
        $data = Excel::toArray([], $this->excelfile);

        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                continue;
            }
            SendTrackNotification::dispatch(trim($row[0]), Carbon::now());
        }
        $this->reset(['singleTrack', 'excelfile']);
        $this->dispatch('alert', 'Данные успешно загружены!');
    }
    public function render()
    {
        return view('livewire.admin.china');
    }
}
