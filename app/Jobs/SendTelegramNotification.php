<?php

namespace App\Jobs;

use App\Models\Notifyqueue;
use App\Texhub\Telegram;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public Notifyqueue $notification;
    /**
     * Create a new job instance.
     */
    public function __construct(Notifyqueue $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sms = new Telegram();
        $sms->sms_send($this->notification->user_id, $this->notification->content);
        $this->notification->update(['status' => 'sent']);
    }
}
