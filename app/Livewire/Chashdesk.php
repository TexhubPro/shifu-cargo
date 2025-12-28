<?php

namespace App\Livewire;

use Flux\Flux;
use App\Models\User;
use App\Models\Setting;
use Livewire\Component;
use App\Models\Expences;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Trackcode;
use App\Models\HeldOrder;
use App\Jobs\CreateCashdeskOrder;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

#[Layout('components.layouts.empty')]
class Chashdesk extends Component
{
    public $user;
    public $queues;
    public $users;
    public $order_no;
    public $weight = 0;
    public $volume = 0;
    public $payment_type = 'Наличными';
    public $total_amount;
    public $received_amount;
    public $discount = 0;
    public $discount_total = 0;
    public $discountt = 'Фиксированная';
    public $total;
    public $total_final;
    public $client;
    public $amount;
    public $tracks = []; // массив трек-кодов
    public $newTrack;    // ввод нового трека
    public $description;
    public $selected_queue;
    public $heldOrders = [];
    public $activeHeldOrderId;
    public $currencyForm = [];
    private array $priceCache = [];
    private ?array $currencyCache = null;
    private ?\Illuminate\Support\Collection $todayOrdersCache = null;
    private ?array $todayOrdersSummaryCache = null;

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function mount()
    {
        $this->queues = Queue::where('status', 'В очереди')->whereDate('created_at', Carbon::today())->get();
        $this->loadUsersCache();
        $this->refreshHeldOrders();
        $this->loadCurrencyForm();
        $this->loadPriceCache();
        $this->total_amounts();
    }
    public function goReports()
    {
        return redirect()->route('cashier.reports');
    }
    public function refreshQueues(): void
    {
        $this->queues = Queue::where('status', 'В очереди')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('created_at')
            ->get();
    }
    public function order_place()
    {
        CreateCashdeskOrder::dispatch([
            'order_no' => $this->order_no,
            'client' => $this->client,
            'weight' => $this->weight,
            'volume' => $this->volume,
            'total_amount' => $this->total_amount,
            'discount_total' => $this->discount_total,
            'total_final' => $this->total_final,
            'tracks' => $this->tracks,
            'selected_queue' => $this->selected_queue,
            'active_held_order_id' => $this->activeHeldOrderId,
        ]);
        $this->resetOrderForm();
        $this->refreshHeldOrders();
        $this->refreshQueues();
        $this->dispatch('order-submitted');
        $this->todayOrdersCache = null;
        $this->todayOrdersSummaryCache = null;
    }
    public function updateTrackStatuses($user_id, $order_id)
    {
        if (empty($this->tracks)) {
        } else {
            foreach ($this->tracks as $code) {
                $track = Trackcode::where('code', trim($code))->first();
                if ($track) {
                    $track->customer = Carbon::now();
                    $track->status = 'Получено';
                    $track->user_id = $user_id ?? $this->client;
                    $track->order_id = $order_id;
                    $track->save();
                } else {
                    Trackcode::create([
                        'code' => trim($code),
                        'china' => Carbon::now(),
                        'dushanbe' => Carbon::now(),
                        'customer' => Carbon::now(),
                        'status' => 'Получено',
                        'user_id' => $user_id ?? $this->client,
                        'order_id' => $order_id
                    ]);
                }
            }
        }
    }
    public function holdCurrentOrder()
    {
        $this->validate([
            'client' => 'required|string',
        ], [
            'client.required' => 'Укажите клиента, чтобы сохранить заказ в удержанные.',
        ]);

        $user = User::where('phone', $this->client)->first();

        HeldOrder::create([
            'user_id' => $user->id ?? null,
            'client' => $this->client,
            'order_no' => $this->order_no,
            'queue_id' => $this->selected_queue,
            'weight' => $this->parseNumber($this->weight),
            'volume' => $this->parseNumber($this->volume),
            'payment_type' => $this->payment_type,
            'total_amount' => $this->parseNumber($this->total_amount),
            'discount' => $this->parseNumber($this->discount),
            'discount_total' => $this->parseNumber($this->discount_total),
            'discountt' => $this->discountt ?? 'Фиксированная',
            'total_final' => $this->parseNumber($this->total_final),
            'tracks' => $this->tracks,
            'meta' => [
                'payment_type' => $this->payment_type,
                'discount_type' => $this->discountt,
                'received_amount' => $this->parseNumber($this->received_amount),
            ],
        ]);

        if ($this->selected_queue) {
            $queue = Queue::find($this->selected_queue);
            if ($queue) {
                $queue->status = 'Удержан';
                $queue->save();
            }
        }

        $this->resetOrderForm();
        $this->refreshHeldOrders();
        $this->dispatch('alert', 'Заказ отправлен в удержанные.');
    }

    public function loadHeldOrder(int $heldOrderId)
    {
        $held = HeldOrder::findOrFail($heldOrderId);

        $this->client = $held->client;
        $this->order_no = $held->order_no;
        $this->weight = $held->weight;
        $this->volume = $held->volume;
        $this->payment_type = $held->payment_type ?? 'Наличными';
        $this->total_amount = $held->total_amount;
        $this->discount = $held->discount;
        $this->discount_total = $held->discount_total;
        $this->discountt = $held->discountt ?? 'Фиксированная';
        $this->total_final = $held->total_final;
        $heldMeta = is_array($held->meta) ? $held->meta : [];
        $this->received_amount = $heldMeta['received_amount'] ?? ($held->total_amount - $held->discount_total);
        $this->tracks = $held->tracks ?? [];
        $this->selected_queue = $held->queue_id;
        $this->activeHeldOrderId = $held->id;

        if ($held->queue_id) {
            $queue = Queue::find($held->queue_id);
            if ($queue) {
                $queue->status = "Касса";
                $queue->save();
            }
        }

        $this->total_amounts();
        $this->dispatch('alert', 'Данные удержанного заказа загружены.');
    }

    public function deleteHeldOrder(int $heldOrderId)
    {
        $held = HeldOrder::find($heldOrderId);

        if (!$held) {
            return;
        }

        if ($held->queue_id) {
            $queue = Queue::find($held->queue_id);
            if ($queue && $queue->status === 'Удержан') {
                $queue->status = 'В очереди';
                $queue->save();
            }
        }

        $held->delete();

        if ($this->activeHeldOrderId === $heldOrderId) {
            $this->resetOrderForm();
            $this->activeHeldOrderId = null;
        }

        $this->refreshHeldOrders();
    }

    public function refreshHeldOrders()
    {
        $this->heldOrders = HeldOrder::latest()->get();
    }

    private function loadUsersCache(): void
    {
        $this->users = Cache::remember('cashdesk.users', 300, function () {
            return User::where('role', 'customer')
                ->orderBy('phone')
                ->get(['id', 'phone', 'name']);
        });
    }
    public function getTodayOrdersProperty()
    {
        if ($this->todayOrdersCache !== null) {
            return $this->todayOrdersCache;
        }

        $this->todayOrdersCache = Order::with(['user'])
            ->whereDate('created_at', Carbon::today())
            ->orderByDesc('created_at')
            ->get();

        return $this->todayOrdersCache;
    }

    public function getTodayOrdersSummaryProperty(): array
    {
        if ($this->todayOrdersSummaryCache !== null) {
            return $this->todayOrdersSummaryCache;
        }
        $orders = $this->todayOrders;
        $this->todayOrdersSummaryCache = [
            'count' => $orders->count(),
            'weight' => $orders->sum('weight'),
            'cube' => $orders->sum('cube'),
            'discount' => $orders->sum('discount'),
            'total' => $orders->sum('total'),
            'subtotal' => $orders->sum('subtotal'),
        ];
        return $this->todayOrdersSummaryCache;
    }

    public function getTodayExpensesProperty()
    {
        return Expences::whereDate('created_at', Carbon::today())
            ->latest()
            ->get();
    }

    public function downloadTodayReport()
    {
        $this->todayOrdersCache = null;
        $this->todayOrdersSummaryCache = null;
        $orders = $this->todayOrders;
        $expenses = $this->todayExpenses;
        if ($orders->isEmpty()) {
            $this->dispatch('alert', 'Сегодня ещё нет заказов для отчёта.');
            return;
        }

        $headers = [
            'ID',
            'Клиент',
            'Телефон',
            'Вес',
            'Объём',
            'Скидка',
            'Подытог',
            'Итог',
            'Доставка',
            'Доставщик',
            'Создан',
        ];

        $lines = [implode(';', $headers)];
        foreach ($orders as $order) {
            $lines[] = implode(';', [
                $order->id,
                optional($order->user)->name ?? '—',
                optional($order->user)->phone ?? '—',
                number_format($order->weight, 2, '.', ''),
                number_format($order->cube, 2, '.', ''),
                number_format($order->discount, 2, '.', ''),
                number_format($order->subtotal, 2, '.', ''),
                number_format($order->total, 2, '.', ''),
                optional($order->created_at)?->format('Y-m-d H:i'),
            ]);
        }

        $summary = $this->todayOrdersSummary;
        $lines[] = '';
        $lines[] = 'ИТОГО;';
        $lines[] = 'Количество;' . $summary['count'];
        $lines[] = 'Вес суммарно;' . number_format($summary['weight'], 2, '.', '');
        $lines[] = 'Объём суммарно;' . number_format($summary['cube'], 2, '.', '');
        $lines[] = 'Скидка суммарно;' . number_format($summary['discount'], 2, '.', '');
        $lines[] = 'Подытог суммарно;' . number_format($summary['subtotal'], 2, '.', '');
        $lines[] = 'Итог суммарно;' . number_format($summary['total'], 2, '.', '');

        if ($expenses->isNotEmpty()) {
            $lines[] = '';
            $lines[] = 'РАСХОДЫ;';
            $lines[] = implode(';', ['ID', 'Склад', 'Сумма', 'Описание', 'Добавлено']);
            foreach ($expenses as $expense) {
                $lines[] = implode(';', [
                    $expense->id,
                    $expense->sklad ?? '—',
                    number_format($expense->total ?? $expense->amount ?? 0, 2, '.', ''),
                    str_replace(["\n", "\r", ';'], ' ', $expense->content ?? ''),
                    optional($expense->data ?? $expense->created_at)->format('Y-m-d H:i'),
                ]);
            }
            $lines[] = 'ИТОГО РАСХОДОВ;' . number_format($expenses->sum('total'), 2, '.', '');
        }

        $csv = implode("\n", $lines);
        $filename = 'orders-' . Carbon::today()->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
    public function loadCurrencyForm(): void
    {
        $settings = Setting::whereIn('name', $this->currencySettingKeys())->get()->keyBy('name');
        $this->currencyForm['course_dollar'] = $settings['course_dollar']->content ?? null;
        $this->currencyCache = $settings->toArray();
    }

    public function saveCurrencySettings(): void
    {
        $this->validate([
            'currencyForm.course_dollar' => 'required|numeric|min:0',
        ], [
            'currencyForm.course_dollar.required' => 'Введите курс доллара.',
            'currencyForm.course_dollar.numeric' => 'Курс должен быть числом.',
            'currencyForm.course_dollar.min' => 'Курс не может быть отрицательным.',
        ]);

        Setting::updateOrCreate(
            ['name' => 'course_dollar'],
            ['content' => $this->currencyForm['course_dollar']]
        );

        $this->loadCurrencyForm();
        $this->loadPriceCache();
        $this->total_amounts();
        $this->dispatch('alert', 'Курс доллара обновлён.');
    }
    public function select_queues($id)
    {
        $queue = Queue::find($id);
        $queue->status = "Касса";
        $queue->save();
        $this->client = $queue->user->phone;
        $this->selected_queue = $queue->id;
        Flux::modals()->close();
    }
    public function updatedDiscount()
    {
        $this->total_amounts();
    }
    public function updatedDiscountt()
    {
        $this->total_amounts();
    }
    public function updatedWeight()
    {
        $this->total_amounts();
        $this->received_amount = $this->total_amount;
    }
    public function updatedVolume()
    {
        $this->total_amounts();
        $this->received_amount = $this->total_amount;
    }
    public function updatedDelivery_price()
    {
        $this->total_amounts();
    }
    public function updatedReceivedAmount()
    {
        $this->total_amounts();
    }

    protected function parseNumber($value): float
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
    private function loadPriceCache(): void
    {
        $settings = Setting::whereIn('name', $this->currencySettingKeys())->get()->keyBy('name');
        $course = (float) ($settings['course_dollar']->content ?? 0);
        $this->priceCache = [
            'course' => $course,
            'kg' => (float) str_replace('$', '', $settings['kg_price']->content ?? 0),
            'kg_10' => (float) str_replace('$', '', $settings['kg_price_10']->content ?? 0),
            'kg_20' => (float) str_replace('$', '', $settings['kg_price_20']->content ?? 0),
            'kg_30' => (float) str_replace('$', '', $settings['kg_price_30']->content ?? 0),
            'cube' => (float) str_replace('$', '', $settings['cube_price']->content ?? 0),
        ];
        $this->currencyCache = $settings->toArray();
    }
    private function priceValue(string $key, string $settingName): float
    {
        if (empty($this->priceCache)) {
            $this->loadPriceCache();
        }

        $price = $this->priceCache[$key] ?? null;
        $course = $this->priceCache['course'] ?? null;

        if ($price === null || $course === null || $course === 0.0) {
            $price = (float) str_replace('$', '', Setting::where('name', $settingName)->value('content'));
            $course = (float) Setting::where('name', 'course_dollar')->value('content');
            $this->priceCache[$key] = $price;
            $this->priceCache['course'] = $course;
        }

        return $price * $course;
    }
    protected function roundPrice(float $value): float
    {
        $fraction = $value - floor($value);

        return $fraction > 0.5 ? ceil($value) : floor($value);
    }

    public function total_amounts()
    {
        $weight = $this->parseNumber($this->weight);
        $volume = $this->parseNumber($this->volume);
        $cube_price = (float) $this->getCubePriceTJS();

        if ($weight <= 10) {
            $kg_total = $weight * (float) $this->getKgPriceTJS();
        } elseif ($weight <= 20) {
            $kg_total = $weight * (float) $this->getKgPrice10TJS();
        } elseif ($weight <= 30) {
            $kg_total = $weight * (float) $this->getKgPrice20TJS();
        } else {
            $kg_total = $weight * (float) $this->getKgPrice30TJS();
        }
        // Расчёт стоимости
        $cube_total = $volume * $cube_price;

        // Общая сумма без скидки
        $this->total_amount = $this->roundPrice($kg_total + $cube_total);

        // Полученная сумма
        $receivedAmountInput = $this->received_amount;
        $receivedAmount = ($receivedAmountInput === null || $receivedAmountInput === '')
            ? 0
            : $this->parseNumber($receivedAmountInput);

        // Расчёт скидки
        $this->discount_total = max(0, $this->total_amount - $receivedAmount);
        $discount = $this->parseNumber($this->discount);
        if ($this->discount_total === 0 && $discount > 0) {
            // Фоллбек для старого ввода скидок
            $this->discount_total = $this->discountt === 'Процентная' || $this->discountt === 'percent'
                ? $this->total_amount * ($discount / 100)
                : $discount;
        }
        $this->discount_total = min($this->discount_total, $this->total_amount);

        $final = $this->total_amount - $this->discount_total;
        $this->total_final = $this->roundPrice(max(0, $final));
    }

    public function addTrack()
    {
        $track = trim($this->newTrack);

        if ($track && !in_array($track, $this->tracks)) {
            $this->tracks[] = $track;
        }
        $this->newTrack = '';
    }

    public function removeTrack($index)
    {
        unset($this->tracks[$index]);
        $this->tracks = array_values($this->tracks);
    }
    public function addExpense()
    {

        Expences::create([
            'sklad' => 'Склад Душанбе',
            'total' => $this->amount,
            'content' => $this->description,
            'data' => Carbon::now(),
        ]);

        $this->reset(['amount', 'description']);
        Flux::modals()->close();
        $this->dispatch('alert', 'Затраты успешно добавлены!');
    }
    private function getKgPriceTJS()
    {
        return $this->priceValue('kg', 'kg_price');
    }
    private function getKgPrice10TJS()
    {
        return $this->priceValue('kg_10', 'kg_price_10');
    }
    private function getKgPrice20TJS()
    {
        return $this->priceValue('kg_20', 'kg_price_20');
    }
    private function getKgPrice30TJS()
    {
        return $this->priceValue('kg_30', 'kg_price_30');
    }

    private function getCubePriceTJS()
    {
        return $this->priceValue('cube', 'cube_price');
    }
    public function render()
    {
        return view('livewire.chashdesk');
    }

    public function getCurrencyInfoProperty(): array
    {
        if ($this->currencyCache === null) {
            $this->currencyCache = Setting::whereIn('name', $this->currencySettingKeys())->get()->keyBy('name')->toArray();
        }

        $settings = $this->currencyCache;
        $course = $settings['course_dollar']['content'] ?? '0';
        $updatedAt = $settings['course_dollar']['updated_at'] ?? null;

        return [
            'course_dollar' => $course,
            'cube_price' => $settings['cube_price']['content'] ?? null,
            'kg_price' => $settings['kg_price']['content'] ?? null,
            'kg_price_10' => $settings['kg_price_10']['content'] ?? null,
            'kg_price_20' => $settings['kg_price_20']['content'] ?? null,
            'kg_price_30' => $settings['kg_price_30']['content'] ?? null,
            'updated_at' => $updatedAt,
        ];
    }

    public function getPriceInfoProperty(): array
    {
        return [
            'kg' => $this->getKgPriceTJS(),
            'kg_10' => $this->getKgPrice10TJS(),
            'kg_20' => $this->getKgPrice20TJS(),
            'kg_30' => $this->getKgPrice30TJS(),
            'cube' => $this->getCubePriceTJS(),
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

    public function getReportStatsProperty(): array
    {
        $today = Carbon::today();

        return [
            'orders_today' => Order::whereDate('created_at', $today)->count(),
            'revenue_today' => Order::whereDate('created_at', $today)->sum('total'),
            'queues_waiting' => Queue::whereDate('created_at', $today)->where('status', 'В очереди')->count(),
            'held_orders' => HeldOrder::count(),
        ];
    }

    private function resetOrderForm(): void
    {
        $this->client = null;
        $this->order_no = null;
        $this->weight = 0;
        $this->volume = 0;
        $this->payment_type = 'Наличными';
        $this->total_amount = 0;
        $this->received_amount = null;
        $this->discount = 0;
        $this->discount_total = 0;
        $this->discountt = 'Фиксированная';
        $this->total_final = 0;
        $this->tracks = [];
        $this->newTrack = null;
        $this->selected_queue = null;
        $this->activeHeldOrderId = null;
        $this->todayOrdersCache = null;
        $this->todayOrdersSummaryCache = null;
        $this->total_amounts();
    }
}
