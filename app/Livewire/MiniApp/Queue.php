<?php

namespace App\Livewire\MiniApp;

use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Queue as ModelsQueue;
use Illuminate\Support\Facades\Auth;

class Queue extends Component
{
    public $queue;
    public $code;
    public function mount()
    {
        $this->queue = ModelsQueue::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->first();
    }
    public function delete($id)
    {
        ModelsQueue::find($id)->delete();
        $this->reset(['queue']);
        $this->dispatch('alert', 'Вы отменили очередь. Используйте код для повторного взятия места.');
    }
    public function load()
    {
        $code = Setting::where('name', 'queue')->first();
        if ($code->content == $this->code) {
            $todayQueue = ModelsQueue::whereDate('created_at', Carbon::today())
                ->orderByDesc('no')
                ->first();

            $no = $todayQueue ? $todayQueue->no + 1 : 0;

            ModelsQueue::create([
                'no' => str_pad($no ? $no + 1 : 1, 4, '0', STR_PAD_LEFT),
                'sex' => Auth::user()->sex,
                'user_id' => Auth::id(),
                'status' => 'В очереди'
            ]);
            return redirect()->route('queue');
        } else {
            $this->dispatch('alert', 'Код подтверждения неверный ❌ Попробуйте ещё раз.');
        }
    }
    public function render()
    {
        return view('livewire.mini-app.queue');
    }
}
