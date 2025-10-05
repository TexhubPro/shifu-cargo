<?php

namespace App\Jobs;

use App\Texhub\Telegram;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBulkSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $message;
    public $user_id;

    public function __construct(string $message,  $user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
    }
    public function handle(): void
    {
        $sms = new Telegram();
        $sms->sms_bulk($this->user_id, $this->message);
    }
}
