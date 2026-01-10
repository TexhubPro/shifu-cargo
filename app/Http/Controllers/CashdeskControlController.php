<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Expences;
use App\Models\HeldOrder;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Setting;
use App\Models\Trackcode;
use App\Models\User;
use App\Models\DelivererPayment;
use App\Texhub\Telegram;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CashdeskControlController extends Controller
{
    public function index(Request $request): View
    {
        $queues = Queue::where('status', 'В очереди')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at')
            ->get();

        $users = User::where('role', 'customer')->get();
        $heldOrders = HeldOrder::latest()->get();
        $todayExpenses = Expences::whereDate('created_at', Carbon::today())
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        $todayDelivererPayments = DelivererPayment::with('deliverer:id,name')
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        $currencyInfo = $this->getCurrencyInfo();
        $priceSettings = $this->getPriceSettings();
        $deliverers = User::where('role', 'deliver')->get(['id', 'name']);

        $defaultForm = [
            'client' => null,
            'weight' => 0,
            'volume' => 0,
            'received_amount' => null,
            'order_no' => null,
            'selected_queue' => null,
            'active_held_order_id' => null,
        ];

        $sessionForm = session()->pull('cashdesk.form', []);
        $form = array_merge($defaultForm, $sessionForm);

        foreach (array_keys($defaultForm) as $key) {
            $oldValue = old($key);
            if ($oldValue !== null) {
                $form[$key] = $oldValue;
            }
        }

        $totals = $this->calculateTotals(
            $form['weight'],
            $form['volume'],
            $form['received_amount'],
            $priceSettings
        );

        return view('cashdesk-control', [
            'queues' => $queues,
            'users' => $users,
            'heldOrders' => $heldOrders,
            'todayExpenses' => $todayExpenses,
            'todayDelivererPayments' => $todayDelivererPayments,
            'currencyInfo' => $currencyInfo,
            'priceSettings' => $priceSettings,
            'deliverers' => $deliverers,
            'form' => $form,
            'totals' => $totals,
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function placeOrder(Request $request)
    {
        $data = $this->validatedOrderData($request);

        if (!empty($data['order_no'])) {
            $application = Application::find($data['order_no']);
            if ($application) {
                $application->status = 'Доставляется';
                $application->save();
            }
        }

        $user = User::where('phone', $data['client'])->first();

        $prices = $this->getPriceSettings();
        $totals = $this->calculateTotals($data['weight'], $data['volume'], $data['received_amount'], $prices);

        $order = Order::create([
            'user_id' => $user->id ?? $data['client'],
            'weight' => $this->parseNumber($data['weight']),
            'cube' => $this->parseNumber($data['volume']),
            'subtotal' => $totals['total_amount'],
            'delivery_total' => 0,
            'deliver_id' => null,
            'discount' => $totals['discount_total'],
            'total' => $totals['total_final'],
            'status' => 'Оплачено',
        ]);

        $trackCodes = $data['tracks'] ?? [];
        $clientValue = $data['client'];
        $userId = $user?->id;
        $orderId = $order->id;

        dispatch(function () use ($userId, $orderId, $trackCodes, $clientValue) {
            try {
                if ($userId) {
                    $sms = new Telegram();
                    $sms->sms_order($userId, $orderId);
                } else {
                }
                $message = "📦 Салом, муштарии муҳтарам!\n\n🚚 Шумо бо муваффақият фармоиши худро қабул/дархост намудед.\n⚖️ Вазн: $order->weight кг\n📏 Ҳаҷм: $order->cube м³\n💰 Ҷамъбаст: $order->subtotal с\n💵 Тахфиф: $order->discount с\n🚛 Нархи бурда расонӣ: $order->delivery_total с\n✅ Ҳамагӣ: $order->total с\n\nТашаккур, ки бо мо ҳастед! 💚";
                $sms_oson = new SmsController();
                $sms_oson->sendSms($clientValue, $message);

                $trackUserId = $userId ?? $clientValue;
                foreach ($trackCodes as $code) {
                    $trimmed = trim($code);
                    if ($trimmed === '') {
                        continue;
                    }

                    $track = Trackcode::where('code', $trimmed)->first();
                    if ($track) {
                        $track->customer = Carbon::now();
                        $track->status = 'Получено';
                        $track->user_id = $trackUserId;
                        $track->order_id = $orderId;
                        $track->save();
                        continue;
                    }

                    Trackcode::create([
                        'code' => $trimmed,
                        'china' => Carbon::now(),
                        'dushanbe' => Carbon::now(),
                        'customer' => Carbon::now(),
                        'status' => 'Получено',
                        'user_id' => $trackUserId,
                        'order_id' => $orderId,
                    ]);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        })->afterResponse();

        if (!empty($data['selected_queue'])) {
            Queue::find($data['selected_queue'])?->delete();
        }

        if (!empty($data['active_held_order_id'])) {
            HeldOrder::find($data['active_held_order_id'])?->delete();
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('cashier')
            ->with('cashdesk.form', ['client' => null]);
    }

    public function holdOrder(Request $request): RedirectResponse
    {
        $data = $this->validatedOrderData($request);

        $user = User::where('phone', $data['client'])->first();
        $prices = $this->getPriceSettings();
        $totals = $this->calculateTotals($data['weight'], $data['volume'], $data['received_amount'], $prices);

        HeldOrder::create([
            'user_id' => $user->id ?? null,
            'client' => $data['client'],
            'order_no' => $data['order_no'] ?? null,
            'queue_id' => $data['selected_queue'] ?? null,
            'weight' => $this->parseNumber($data['weight']),
            'volume' => $this->parseNumber($data['volume']),
            'payment_type' => 'Наличными',
            'total_amount' => $totals['total_amount'],
            'discount' => 0,
            'discount_total' => $totals['discount_total'],
            'discountt' => 'Фиксированная',
            'total_final' => $totals['total_final'],
            'tracks' => $data['tracks'] ?? [],
            'meta' => [
                'payment_type' => 'Наличными',
                'discount_type' => 'Фиксированная',
                'received_amount' => $this->parseNumber($data['received_amount']),
            ],
        ]);

        if (!empty($data['selected_queue'])) {
            $queue = Queue::find($data['selected_queue']);
            if ($queue) {
                $queue->status = 'Удержан';
                $queue->save();
            }
        }

        return redirect()->route('cashier');
    }

    public function loadHeldOrder(HeldOrder $heldOrder): RedirectResponse
    {
        $form = [
            'client' => $heldOrder->client,
            'order_no' => $heldOrder->order_no,
            'weight' => $heldOrder->weight,
            'volume' => $heldOrder->volume,
            'received_amount' => $heldOrder->meta['received_amount'] ?? null,
            'selected_queue' => $heldOrder->queue_id,
            'active_held_order_id' => $heldOrder->id,
        ];

        return redirect()->route('cashier')->with('cashdesk.form', $form);
    }

    public function deleteHeldOrder(HeldOrder $heldOrder): RedirectResponse
    {
        $heldOrder->delete();

        return redirect()->route('cashier');
    }

    public function selectQueue(Queue $queue): RedirectResponse
    {
        $queue->status = 'Касса';
        $queue->save();

        $form = [
            'client' => $queue->user?->phone,
            'selected_queue' => $queue->id,
        ];

        return redirect()->route('cashier')->with('cashdesk.form', $form);
    }

    public function addExpense(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        Expences::create([
            'sklad' => 'Склад Душанбе',
            'total' => $data['amount'],
            'content' => $data['description'] ?? null,
            'data' => Carbon::now(),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('cashier');
    }

    public function saveCurrency(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_dollar' => ['required', 'numeric', 'min:0'],
        ]);

        Setting::updateOrCreate(
            ['name' => 'course_dollar'],
            ['content' => $data['course_dollar']]
        );

        return redirect()->route('cashier');
    }

    public function addDelivererPayment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'deliverer_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        DelivererPayment::create([
            'deliverer_id' => $data['deliverer_id'],
            'cashier_id' => Auth::id(),
            'amount' => $data['amount'],
            'note' => $data['note'] ?? null,
        ]);

        return redirect()->route('cashier');
    }

    private function validatedOrderData(Request $request): array
    {
        return $request->validate([
            'client' => ['required', 'string'],
            'weight' => ['nullable'],
            'volume' => ['nullable'],
            'received_amount' => ['nullable'],
            'order_no' => ['nullable'],
            'selected_queue' => ['nullable'],
            'active_held_order_id' => ['nullable'],
        ]);
    }

    private function updateTrackStatuses(?int $userId, int $orderId, array $tracks): void
    {
        foreach ($tracks as $code) {
            $trimmed = trim($code);
            if ($trimmed === '') {
                continue;
            }

            $track = Trackcode::where('code', $trimmed)->first();
            if ($track) {
                $track->customer = Carbon::now();
                $track->status = 'Получено';
                $track->user_id = $userId;
                $track->order_id = $orderId;
                $track->save();
                continue;
            }

            Trackcode::create([
                'code' => $trimmed,
                'china' => Carbon::now(),
                'dushanbe' => Carbon::now(),
                'customer' => Carbon::now(),
                'status' => 'Получено',
                'user_id' => $userId,
                'order_id' => $orderId,
            ]);
        }
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

    private function roundPrice(float $value): float
    {
        $fraction = $value - floor($value);

        return $fraction > 0.5 ? ceil($value) : floor($value);
    }

    private function getCurrencyInfo(): array
    {
        $settings = Setting::whereIn('name', $this->currencySettingKeys())->get()->keyBy('name');
        $course = $settings['course_dollar']->content ?? '0';
        $updatedAt = $settings['course_dollar']->updated_at ?? null;

        return [
            'course_dollar' => $course,
            'cube_price' => $settings['cube_price']->content ?? null,
            'kg_price' => $settings['kg_price']->content ?? null,
            'kg_price_10' => $settings['kg_price_10']->content ?? null,
            'kg_price_20' => $settings['kg_price_20']->content ?? null,
            'kg_price_30' => $settings['kg_price_30']->content ?? null,
            'updated_at' => $updatedAt,
        ];
    }

    private function getPriceSettings(): array
    {
        $settings = Setting::whereIn('name', $this->currencySettingKeys())->get()->keyBy('name');
        $course = (float) ($settings['course_dollar']->content ?? 0);

        return [
            'course' => $course,
            'kg' => (float) str_replace('$', '', $settings['kg_price']->content ?? 0),
            'kg_10' => (float) str_replace('$', '', $settings['kg_price_10']->content ?? 0),
            'kg_20' => (float) str_replace('$', '', $settings['kg_price_20']->content ?? 0),
            'kg_30' => (float) str_replace('$', '', $settings['kg_price_30']->content ?? 0),
            'cube' => (float) str_replace('$', '', $settings['cube_price']->content ?? 0),
        ];
    }

    private function calculateTotals($weight, $volume, $receivedAmount, array $prices): array
    {
        $weightValue = $this->parseNumber($weight);
        $volumeValue = $this->parseNumber($volume);

        $course = $prices['course'] ?? 0;
        $cubePrice = ($prices['cube'] ?? 0) * $course;

        if ($weightValue <= 10) {
            $kgTotal = $weightValue * (($prices['kg'] ?? 0) * $course);
        } elseif ($weightValue <= 20) {
            $kgTotal = $weightValue * (($prices['kg_10'] ?? 0) * $course);
        } elseif ($weightValue <= 30) {
            $kgTotal = $weightValue * (($prices['kg_20'] ?? 0) * $course);
        } else {
            $kgTotal = $weightValue * (($prices['kg_30'] ?? 0) * $course);
        }

        if ($weightValue > 0 && $kgTotal < 10) {
            $kgTotal = 10;
        }

        $cubeTotal = $volumeValue * $cubePrice;
        $totalAmount = $this->roundPrice($kgTotal + $cubeTotal);

        $received = $this->parseNumber($receivedAmount);
        $discountTotal = max(0, $totalAmount - $received);
        $discountTotal = min($discountTotal, $totalAmount);

        $totalFinal = $this->roundPrice(max(0, $totalAmount - $discountTotal));

        return [
            'total_amount' => $totalAmount,
            'discount_total' => $discountTotal,
            'total_final' => $totalFinal,
        ];
    }

    private function currencySettingKeys(): array
    {
        return [
            'course_dollar',
            'kg_price',
            'kg_price_10',
            'kg_price_20',
            'kg_price_30',
            'cube_price',
        ];
    }
}
