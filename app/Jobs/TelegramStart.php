<?php

namespace App\Jobs;

use App\Texhub\Telegram;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TelegramStart implements ShouldQueue
{
    use Queueable;
    public $user_id;
    /**
     * Create a new job instance.
     */
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sms = new Telegram();
        $sms->sms_bulk_preview($this->user_id);
    }
}
