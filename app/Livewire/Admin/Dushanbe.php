<?php

namespace App\Livewire\Admin;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Trackcode;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Jobs\SendTrackDushanbe;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.admin')]
class Dushanbe extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $excelFilewriteOffItem;
    public $excelFile;
    public $flightDates;
    public $user_code;
    public $user_id = null;
    #[Computed]
    public function trackcodes()
    {
        $query = Trackcode::query()
            ->where('status', 'В пункте выдачи');

        if (!empty($this->search)) {
            $query->where('code', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->user_code)) {
            $query->where('user_id', $this->user_id);
        }

        return $query->orderByDesc('created_at')
            ->paginate(50);
    }

    public function check_user()
    {
        $user = User::where('code', $this->user_code)->first();

        if ($user) {
            $this->user_id = $user->id;
        } else {
            $this->user_id = null;
            $this->dispatch('alert', 'Пользователь не найден!');
        }
    }
    public function mount()
    {
        //
    }

    public function writeOffItem()
    {
        $this->validate([
            'excelFilewriteOffItem' => 'required|file|mimes:xlsx,csv',
        ]);

        // Читаем массив из Excel
        $data = Excel::toArray([], $this->excelFilewriteOffItem);

        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                continue;
            }
            Trackcode::updateOrCreate(
                ['code' => trim($row[0])], // условие поиска
                [
                    'customer' => $row[6] ?? null,
                    'status' => 'Получено',
                ]
            );
        }
        $this->reset([
            'excelFilewriteOffItem',
            'excelFile',
            'flightDates',
        ]);
        $this->dispatch('alert', 'Данные успешно списано!');
    }
    public function importExcel()
    {
        $this->validate([
            'excelFile' => 'required|file|mimes:xlsx,csv',
        ]);

        // Читаем массив из Excel
        $data = Excel::toArray([], $this->excelFile);

        foreach ($data[0] as $key => $row) {
            if ($key == 0) {
                continue;
            }
            SendTrackDushanbe::dispatch(trim($row[0]), $this->flightDates ?? Carbon::now());
        }
        $this->reset([
            'excelFilewriteOffItem',
            'excelFile',
            'flightDates',
        ]);
        $this->dispatch('alert', 'Данные успешно загружены!');
    }
    public function render()
    {
        return view('livewire.admin.dushanbe');
    }
}
