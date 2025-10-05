<?php

namespace App\Jobs;

use App\Models\Trackcode;
use App\Texhub\Telegram;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTrackDushanbe implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $trackcode;
    public $date;

    public function __construct(string $trackcode,  $date = null)
    {
        $this->trackcode = $trackcode;
        $this->date = $date;
    }

    public function handle()
    {
        $trackcode = Trackcode::where('code', $this->trackcode)->first();
        if ($trackcode) {
            $trackcode->race = $this->date;
            $trackcode->dushanbe = Carbon::now();
            $trackcode->status = 'В пункте выдачи';
            $trackcode->save();
            if ($trackcode->user_id) {
                $sms = new Telegram();
                $sms->sms_send_dushanbe($trackcode->user_id, $trackcode);
            }
        } else {
            Trackcode::create([
                'code' => $this->trackcode,
                'china' => Carbon::now(),
                'race' => $this->date,
                'dushanbe' => Carbon::now(),
                'status' => 'В пункте выдачи'
            ]);
        }
        sleep(1);
    }
}
