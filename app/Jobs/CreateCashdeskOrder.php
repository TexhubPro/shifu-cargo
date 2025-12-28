<?php

namespace App\Jobs;

use App\Models\Application;
use App\Models\HeldOrder;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Trackcode;
use App\Models\User;
use App\Texhub\Telegram;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateCashdeskOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly array $payload
    ) {}

    public function handle(): void
    {
        $data = $this->payload;

        DB::transaction(function () use ($data) {
            if (!empty($data['order_no'])) {
                $apl = Application::find($data['order_no']);
                if ($apl) {
                    $apl->status = 'Доставляется';
                    $apl->save();
                }
            }

            $user = null;
            if (!empty($data['client'])) {
                $user = User::where('phone', $data['client'])->first();
            }

            $weight = $this->parseNumber($data['weight'] ?? 0);
            $volume = $this->parseNumber($data['volume'] ?? 0);
            $subtotal = $this->parseNumber($data['total_amount'] ?? 0);
            $discountTotal = $this->parseNumber($data['discount_total'] ?? 0);
            $totalFinal = $this->parseNumber($data['total_final'] ?? 0);

            $order = Order::create([
                'user_id' => $user->id ?? ($data['client'] ?? null),
                'weight' => $weight,
                'cube' => $volume,
                'subtotal' => $subtotal,
                'delivery_total' => 0,
                'deliver_id' => null,
                'discount' => $discountTotal,
                'total' => $totalFinal,
                'status' => 'Оплачено',
            ]);

            if ($user) {
                $sms = new Telegram();
                $sms->sms_order($user->id, $order->id);
            }

            $this->updateTrackStatuses(
                $data['tracks'] ?? [],
                $user?->id,
                $data['client'] ?? null,
                $order->id
            );

            if (!empty($data['selected_queue'])) {
                Queue::find($data['selected_queue'])?->delete();
            }

            if (!empty($data['active_held_order_id'])) {
                HeldOrder::find($data['active_held_order_id'])?->delete();
            }
        });
    }

    private function parseNumber($value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        if (is_string($value)) {
            $normalized = str_replace([' ', ','], ['', '.'], $value);
            if (is_numeric($normalized)) {
                return (float) $normalized;
            }
        }

        return (float) $value;
    }

    private function updateTrackStatuses(array $tracks, ?int $userId, ?string $clientPhone, int $orderId): void
    {
        if (empty($tracks)) {
            return;
        }

        foreach ($tracks as $code) {
            $track = Trackcode::where('code', trim($code))->first();
            if ($track) {
                $track->customer = Carbon::now();
                $track->status = 'Получено';
                $track->user_id = $userId ?? $clientPhone;
                $track->order_id = $orderId;
                $track->save();
                continue;
            }

            Trackcode::create([
                'code' => trim($code),
                'china' => Carbon::now(),
                'dushanbe' => Carbon::now(),
                'customer' => Carbon::now(),
                'status' => 'Получено',
                'user_id' => $userId ?? $clientPhone,
                'order_id' => $orderId,
            ]);
        }
    }
}
