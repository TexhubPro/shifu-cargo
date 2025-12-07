<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Queue;
use Carbon\Carbon;
use App\Http\Controllers\SmsController;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.empty')]
class QueueKiosk extends Component
{
    public $phoneInput = '';
    public $assignedNumber = null;
    public $statusMessage = null;
    public $errorMessage = null;
    public $awaitingConfirmation = false;
    public $pendingUserId = null;
    public $pendingPhoneDisplay = null;
    public $showAlternateInput = false;
    public $lastEnteredDigits = '';

    public function appendDigit(string $digit): void
    {
        if (strlen($this->phoneInput) >= 9) {
            return;
        }

        $this->phoneInput .= $digit;
    }

    public function removeDigit(): void
    {
        $this->phoneInput = substr($this->phoneInput, 0, -1);
    }

    public function resetInput(): void
    {
        $this->phoneInput = '';
        $this->statusMessage = null;
        $this->errorMessage = null;
        $this->assignedNumber = null;
        $this->awaitingConfirmation = false;
        $this->pendingUserId = null;
        $this->pendingPhoneDisplay = null;
        $this->showAlternateInput = false;
        $this->lastEnteredDigits = '';
    }

    public function takeQueue(): void
    {
        $this->statusMessage = null;
        $this->errorMessage = null;
        $this->awaitingConfirmation = false;
        $this->pendingUserId = null;
        $this->pendingPhoneDisplay = null;
        $this->showAlternateInput = false;
        $digits = preg_replace('/\D/', '', $this->phoneInput);

        if (strlen($digits) !== 9) {
            $this->errorMessage = 'Номер телефона должен содержать ровно 9 цифр.';
            return;
        }

        $candidates = [
            '+992' . $digits,
            '992' . $digits,
            $digits,
        ];

        $user = User::whereIn('phone', $candidates)->first();
        if (!$user) {
            $this->errorMessage = 'Номер не найден. Проверьте правильность и попробуйте снова.';
            return;
        }
        $this->lastEnteredDigits = $digits;

        $existing = Queue::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($existing) {
            $this->assignedNumber = $existing->no;
            $this->statusMessage = "Вы уже в очереди. Ваш номер {$existing->no}.";
            $this->phoneInput = '';
            $this->dispatch('queue-cleared');
            return;
        }

        $this->awaitingConfirmation = true;
        $this->pendingUserId = $user->id;
        $this->pendingPhoneDisplay = $user->phone ?? '+992 ' . $digits;
        $this->statusMessage = 'Укажите, есть ли этот номер у вас под рукой.';
        $this->phoneInput = '';
    }

    public function confirmOriginalPhone(): void
    {
        if (!$this->pendingUserId) {
            return;
        }

        $user = User::find($this->pendingUserId);

        if (!$user) {
            $this->errorMessage = 'Пользователь не найден.';
            $this->clearPendingConfirmation();
            return;
        }

        $queue = $this->createQueueForUser($user);
        $this->sendQueueNotification($user->phone, $queue->no, $this->lastEnteredDigits);
        $this->assignedNumber = $queue->no;
        $this->statusMessage = "Ваш номер {$queue->no}. Просим ожидать вызова.";

        $this->clearPendingConfirmation();
        $this->dispatch('queue-cleared');
    }

    public function startAlternatePhone(): void
    {
        if (!$this->pendingUserId) {
            return;
        }

        $this->showAlternateInput = true;
        $this->errorMessage = null;
        $this->phoneInput = '';
        $this->statusMessage = 'Введите номер, который сейчас у вас в руках, используя клавиатуру ниже.';
    }

    public function confirmAlternatePhone(): void
    {
        if (!$this->pendingUserId) {
            return;
        }

        $digits = preg_replace('/\D/', '', $this->phoneInput);
        if (strlen($digits) !== 9) {
            $this->errorMessage = 'Введите контактный номер из 9 цифр.';
            return;
        }

        $user = User::find($this->pendingUserId);
        if (!$user) {
            $this->errorMessage = 'Пользователь не найден.';
            $this->clearPendingConfirmation();
            return;
        }

        $queue = $this->createQueueForUser($user);
        $contactPhone = $digits;
        $this->sendQueueNotification($contactPhone, $queue->no);

        $this->assignedNumber = $queue->no;
        $this->statusMessage = "Ваш номер {$queue->no}. SMS отправлена на {$contactPhone}.";

        $this->clearPendingConfirmation();
        $this->dispatch('queue-cleared');
    }

    public function render()
    {
        return view('livewire.queue-kiosk');
    }

    public function getDisplayDigitsProperty(): array
    {
        if ($this->showAlternateInput) {
            return str_split(preg_replace('/\D/', '', $this->phoneInput));
        }

        if ($this->awaitingConfirmation && $this->lastEnteredDigits !== '') {
            return str_split($this->lastEnteredDigits);
        }

        return str_split(preg_replace('/\D/', '', $this->phoneInput));
    }

    protected function createQueueForUser(User $user): Queue
    {
        $last = Queue::whereDate('created_at', Carbon::today())
            ->orderByDesc('no')
            ->first();

        $nextNo = $last ? (int) $last->no + 1 : 1;

        return Queue::create([
            'no' => str_pad($nextNo, 4, '0', STR_PAD_LEFT),
            'sex' => $user->sex ?? 'm',
            'user_id' => $user->id,
            'status' => 'В очереди',
        ]);
    }

    protected function clearPendingConfirmation(): void
    {
        $this->awaitingConfirmation = false;
        $this->pendingUserId = null;
        $this->pendingPhoneDisplay = null;
        $this->showAlternateInput = false;
        $this->lastEnteredDigits = '';
    }

    protected function sendQueueNotification(?string $rawPhone, string $queueNumber, ?string $digitsFallback = null): void
    {
        $targetPhone = $this->resolvePhone($rawPhone, $digitsFallback);

        if (!$targetPhone) {
            return;
        }

        $message = "Ваш номер очереди {$queueNumber}. Пожалуйста, ожидайте вызова. Мы уведомим вас о статусе.";
        $sms = new SmsController();
        $sms->sendSms($targetPhone, $message);
    }

    protected function resolvePhone(?string $phone, ?string $digitsFallback = null): ?string
    {
        $raw = trim((string) $phone);
        if ($raw !== '') {
            return preg_replace('/\s+/', '', $raw);
        }

        $digits = preg_replace('/\D/', '', (string) $digitsFallback);
        return $digits !== '' ? $digits : null;
    }

}
