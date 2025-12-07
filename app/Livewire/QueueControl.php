<?php

namespace App\Livewire;

use App\Http\Controllers\SmsController;
use App\Models\Queue;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.empty')]

class QueueControl extends Component
{
    public $waitingQueues;
    public $approvedQueues;

    public function mount(): void
    {
        $this->loadQueues();
    }

    public function refreshQueues(): void
    {
        $this->loadQueues();
    }

    public function approve(int $queueId): void
    {
        $queue = Queue::find($queueId);

        if (!$queue) {
            return;
        }

        $queue->status = 'Подтверждено';
        $queue->save();

        $this->loadQueues();
    }

    public function cancel(int $queueId): void
    {
        $queue = Queue::with('user')->find($queueId);

        if (!$queue) {
            return;
        }

        $phone = $queue->user->phone ?? null;
        $queue->delete();

        if ($phone) {
            $message = 'На складе не найдено ваши товары. Для подробностей обратитесь к сотруднику склада.';
            (new SmsController())->sendSms($phone, $message);
        }

        $this->loadQueues();
    }

    public function complete(int $queueId): void
    {
        $queue = Queue::find($queueId);

        if (!$queue) {
            return;
        }

        $queue->delete();
        $this->loadQueues();
    }

    public function render()
    {
        return view('livewire.queue-control');
    }

    protected function loadQueues(): void
    {
        $queues = Queue::with('user')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at')
            ->get();

        $this->waitingQueues = $queues->where('status', '!=', 'Подтверждено')->values();
        $this->approvedQueues = $queues->where('status', 'Подтверждено')->values();
    }
}
