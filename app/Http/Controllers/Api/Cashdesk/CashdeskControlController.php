<?php

namespace App\Http\Controllers\Api\Cashdesk;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Models\Application;
use App\Models\DelivererPayment;
use App\Models\Expences;
use App\Models\HeldOrder;
use App\Models\Order;
use App\Models\Queue;
use App\Models\Setting;
use App\Models\Trackcode;
use App\Models\User;
use App\Texhub\Telegram;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CashdeskControlController extends Controller
{
    private const DEFAULT_PAYMENT_TYPE = 'Наличными';

    /**
     * Возвращает справочные данные для формы кассы.
     */
    public function meta(): JsonResponse
    {
        return response()->json([
            'client_code_prefix' => 'SF',
            'payment_methods' => $this->paymentMethods(),
            'currency' => $this->getCurrencyInfo(),
            'prices' => $this->getPriceSettings(),
        ]);
    }

    /**
     * Возвращает список пользователей для локальной синхронизации кассы.
     */
    public function users(): JsonResponse
    {
        $users = User::query()
            ->select([
                'id',
                'name',
                'code',
                'phone',
                'role',
                'warehouse_id',
                'created_at',
                'updated_at',
            ])
            ->orderBy('id')
            ->get()
            ->map(static function (User $user): array {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'code' => $user->code,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'warehouse_id' => $user->warehouse_id,
                    'created_at' => $user->created_at?->toIso8601String(),
                    'updated_at' => $user->updated_at?->toIso8601String(),
                ];
            })
            ->values();

        return response()->json([
            'count' => $users->count(),
            'users' => $users,
        ]);
    }

    /**
     * Оформляет заказ через API кассы.
     */
    public function placeOrder(Request $request): JsonResponse
    {
        $data = $this->validatedOrderData($request);
        $createdAt = !empty($data['created_at'])
            ? Carbon::parse($data['created_at'])
            : null;

        if (!empty($data['order_no'])) {
            $application = Application::find($data['order_no']);
            if ($application) {
                $application->status = 'Доставляется';
                $application->save();
            }
        }

        $clientPhone = trim((string) $data['client']);
        $clientCode = $this->normalizeClientCode($data['client_code'] ?? null);
        $paymentType = $this->normalizePaymentType($data['payment_type'] ?? null);
        $cashier = $request->user();
        $warehouseId = $cashier?->warehouse_id;
        $cashierId = isset($data['cashier_id']) && (int) $data['cashier_id'] > 0
            ? (int) $data['cashier_id']
            : ($cashier?->id ?? Auth::id());

        $user = User::where('phone', $clientPhone)->first();
        $prices = $this->getPriceSettings();
        $totals = $this->calculateTotals($data['weight'], $data['volume'], $data['received_amount'], $prices);

        $order = Order::create($this->filterExistingColumns('orders', [
            'user_id' => $user->id ?? $clientPhone,
            'cashier_id' => $cashierId,
            'warehouse_id' => $warehouseId,
            'weight' => $this->parseNumber($data['weight']),
            'cube' => $this->parseNumber($data['volume']),
            'subtotal' => $totals['total_amount'],
            'delivery_total' => 0,
            'deliver_id' => null,
            'discount' => $totals['discount_total'],
            'total' => $totals['total_final'],
            'status' => 'Оплачено',
            'payment_type' => $paymentType,
        ]));

        if ($createdAt !== null) {
            $order->forceFill([
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ])->saveQuietly();
        }

        $trackCodes = $data['tracks'] ?? [];
        $trackUserId = $user?->id ?? $clientPhone;
        $this->updateTrackStatuses($trackUserId, $order->id, $trackCodes);

        $this->notifyAboutOrder($user?->id, $order->id, $clientPhone, $order);

        $this->clearClientFromQueueAfterOrder($user?->id, $data['selected_queue'] ?? null);

        if (!empty($data['active_held_order_id'])) {
            HeldOrder::find($data['active_held_order_id'])?->delete();
        }

        return response()->json([
            'message' => 'Заказ успешно оформлен.',
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
                'client' => $clientPhone,
                'client_code' => $clientCode,
                'payment_type' => $paymentType,
                'tracks_count' => count(array_filter($trackCodes, static fn ($track) => trim((string) $track) !== '')),
            ],
            'totals' => $totals,
        ]);
    }

    /**
     * Сохраняет заказ в удержанные через API кассы.
     */
    public function holdOrder(Request $request): JsonResponse
    {
        $data = $this->validatedOrderData($request);

        $clientPhone = trim((string) $data['client']);
        $clientCode = $this->normalizeClientCode($data['client_code'] ?? null);
        $paymentType = $this->normalizePaymentType($data['payment_type'] ?? null);
        $tracks = $data['tracks'] ?? [];

        $user = User::where('phone', $clientPhone)->first();
        $prices = $this->getPriceSettings();
        $totals = $this->calculateTotals($data['weight'], $data['volume'], $data['received_amount'], $prices);

        $held = HeldOrder::create([
            'user_id' => $user->id ?? null,
            'client' => $clientPhone,
            'order_no' => $data['order_no'] ?? null,
            'queue_id' => $data['selected_queue'] ?? null,
            'weight' => $this->parseNumber($data['weight']),
            'volume' => $this->parseNumber($data['volume']),
            'payment_type' => $paymentType,
            'total_amount' => $totals['total_amount'],
            'discount' => 0,
            'discount_total' => $totals['discount_total'],
            'discountt' => 'Фиксированная',
            'total_final' => $totals['total_final'],
            'tracks' => $tracks,
            'meta' => [
                'payment_type' => $paymentType,
                'discount_type' => 'Фиксированная',
                'received_amount' => $this->parseNumber($data['received_amount']),
                'client_code' => $clientCode,
            ],
        ]);

        if (!empty($data['selected_queue'])) {
            $queue = Queue::find($data['selected_queue']);
            if ($queue) {
                $queue->status = 'Удержан';
                $queue->save();
            }
        }

        return response()->json([
            'message' => 'Заказ удержан.',
            'held_order' => [
                'id' => $held->id,
                'created_at' => $held->created_at?->toIso8601String(),
                'client' => $clientPhone,
                'client_code' => $clientCode,
                'payment_type' => $paymentType,
                'tracks_count' => count(array_filter($tracks, static fn ($track) => trim((string) $track) !== '')),
            ],
            'totals' => $totals,
        ]);
    }

    /**
     * Добавляет расход через API кассы.
     */
    public function addExpense(Request $request): JsonResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $cashier = $request->user();
        $warehouseId = $cashier?->warehouse_id;
        $warehouseName = trim((string) ($cashier?->warehouse?->name ?? ''));

        $expense = Expences::create($this->filterExistingColumns('expences', [
            'sklad' => $warehouseName !== '' ? $warehouseName : 'Склад Душанбе',
            'total' => $this->parseNumber($data['amount']),
            'content' => $data['description'] ?? null,
            'data' => Carbon::now(),
            'user_id' => $cashier?->id ?? Auth::id(),
            'added_by_id' => $cashier?->id ?? Auth::id(),
            'warehouse_id' => $warehouseId,
        ]));

        return response()->json([
            'message' => 'Расход успешно добавлен.',
            'expense' => [
                'id' => $expense->id,
                'amount' => (float) $expense->total,
                'description' => $expense->content,
                'created_at' => $expense->created_at?->toIso8601String(),
            ],
        ], 201);
    }

    /**
     * Обновляет курс доллара через API кассы.
     */
    public function saveCurrency(Request $request): JsonResponse
    {
        $data = $request->validate([
            'course_dollar' => ['required', 'numeric', 'min:0'],
        ]);

        Setting::updateOrCreate(
            ['name' => 'course_dollar'],
            ['content' => $data['course_dollar']]
        );

        return response()->json([
            'message' => 'Курс успешно обновлён.',
            'course_dollar' => (string) $data['course_dollar'],
        ]);
    }

    /**
     * Возвращает сводный отчёт кассы за текущий день.
     */
    public function todayReport(Request $request): JsonResponse
    {
        $today = Carbon::today();
        $cashierId = $request->user()?->id;
        $orders = $this->getTodayOrders($today);
        $summary = $this->buildTodayOrdersSummary($orders);

        $todayExpensesTotal = Expences::query()
            ->whereDate('created_at', $today)
            ->when($cashierId, static fn ($query) => $query->where('user_id', $cashierId))
            ->sum('total');

        return response()->json([
            'report_stats' => $this->buildReportStats($today),
            'today_orders_summary' => $summary,
            'today_expenses_total' => (float) $todayExpensesTotal,
            'today_orders' => $orders
                ->map(fn (Order $order): array => $this->mapTodayOrder($order))
                ->values(),
        ]);
    }

    /**
     * Скачивает отчёт кассы за текущий день в CSV (для Excel).
     */
    public function downloadTodayReport(Request $request): StreamedResponse
    {
        $today = Carbon::today();
        $cashierId = $request->user()?->id;
        $orders = $this->getTodayOrders($today);
        $summary = $this->buildTodayOrdersSummary($orders);

        $expenses = Expences::query()
            ->whereDate('created_at', $today)
            ->when($cashierId, static fn ($query) => $query->where('user_id', $cashierId))
            ->latest()
            ->get();

        $delivererPayments = DelivererPayment::query()
            ->with('deliverer:id,name')
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        $lines = [];
        $lines[] = implode(';', [
            'ID',
            'Клиент',
            'Телефон',
            'Вес',
            'Объём',
            'Скидка',
            'Подытог',
            'Итог',
            'Создан',
        ]);

        foreach ($orders as $order) {
            $phone = trim((string) (optional($order->user)->phone ?? $order->user_id));
            $lines[] = implode(';', [
                $order->id,
                $this->csvValue(optional($order->user)->name ?? '—'),
                $this->csvValue($phone !== '' ? $phone : '—'),
                number_format($this->parseNumber($order->weight), 2, '.', ''),
                number_format($this->parseNumber($order->cube), 2, '.', ''),
                number_format($this->parseNumber($order->discount), 2, '.', ''),
                number_format($this->parseNumber($order->subtotal), 2, '.', ''),
                number_format($this->parseNumber($order->total), 2, '.', ''),
                optional($order->created_at)?->format('Y-m-d H:i'),
            ]);
        }

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
                    $this->csvValue($expense->sklad ?? '—'),
                    number_format($this->parseNumber($expense->total), 2, '.', ''),
                    $this->csvValue($expense->content ?? ''),
                    optional($expense->data ?? $expense->created_at)?->format('Y-m-d H:i'),
                ]);
            }

            $lines[] = 'ИТОГО РАСХОДОВ;' . number_format($expenses->sum('total'), 2, '.', '');
        }

        if ($delivererPayments->isNotEmpty()) {
            $lines[] = '';
            $lines[] = 'ПОСТУПЛЕНИЯ ОТ ДОСТАВЩИКОВ;';
            $lines[] = implode(';', ['ID', 'Доставщик', 'Сумма', 'Примечание', 'Добавлено']);

            foreach ($delivererPayments as $payment) {
                $lines[] = implode(';', [
                    $payment->id,
                    $this->csvValue($payment->deliverer?->name ?? '—'),
                    number_format($this->parseNumber($payment->amount), 2, '.', ''),
                    $this->csvValue($payment->note ?? ''),
                    optional($payment->created_at)?->format('Y-m-d H:i'),
                ]);
            }

            $lines[] = 'ИТОГО ОТ ДОСТАВЩИКОВ;' . number_format($delivererPayments->sum('amount'), 2, '.', '');
        }

        $csv = implode("\n", $lines);
        $filename = 'cashdesk-report-' . $today->format('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($csv) {
            echo "\xEF\xBB\xBF";
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function validatedOrderData(Request $request): array
    {
        return $request->validate([
            'client' => ['required', 'string', 'max:50'],
            'client_code' => ['nullable', 'string', 'max:50'],
            'payment_type' => ['nullable', 'string', 'max:50'],
            'cashier_id' => ['nullable', 'integer', 'exists:users,id'],
            'weight' => ['nullable'],
            'volume' => ['nullable'],
            'received_amount' => ['nullable'],
            'created_at' => ['nullable', 'date'],
            'order_no' => ['nullable'],
            'selected_queue' => ['nullable'],
            'active_held_order_id' => ['nullable'],
            'tracks' => ['nullable', 'array'],
            'tracks.*' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * После оформления заказа удаляет клиента из очереди:
     * 1) Явно выбранную запись очереди (если передана).
     * 2) Все сегодняшние записи этого клиента в очереди.
     */
    private function clearClientFromQueueAfterOrder(?int $userId, mixed $selectedQueueId): void
    {
        $queueId = (int) $selectedQueueId;
        if ($queueId > 0) {
            Queue::query()->whereKey($queueId)->delete();
        }

        if (!$userId) {
            return;
        }

        Queue::query()
            ->where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->delete();
    }

    private function getTodayOrders(Carbon $today): Collection
    {
        return Order::query()
            ->with('user:id,name,phone')
            ->whereNull('application_id')
            ->whereDate('created_at', $today)
            ->orderByDesc('created_at')
            ->get();
    }

    private function buildTodayOrdersSummary(Collection $orders): array
    {
        return [
            'count' => $orders->count(),
            'weight' => (float) $orders->sum('weight'),
            'cube' => (float) $orders->sum('cube'),
            'discount' => (float) $orders->sum('discount'),
            'subtotal' => (float) $orders->sum('subtotal'),
            'total' => (float) $orders->sum('total'),
        ];
    }

    private function mapTodayOrder(Order $order): array
    {
        $phone = trim((string) (optional($order->user)->phone ?? $order->user_id));

        return [
            'id' => $order->id,
            'phone' => $phone !== '' ? $phone : 'Без телефона',
            'weight' => (float) $this->parseNumber($order->weight),
            'cube' => (float) $this->parseNumber($order->cube),
            'discount' => (float) $this->parseNumber($order->discount),
            'subtotal' => (float) $this->parseNumber($order->subtotal),
            'total' => (float) $this->parseNumber($order->total),
            'created_at' => $order->created_at?->toIso8601String(),
            'created_time' => $order->created_at?->format('H:i'),
        ];
    }

    private function buildReportStats(Carbon $today): array
    {
        return [
            'orders_today' => Order::query()
                ->whereNull('application_id')
                ->whereDate('created_at', $today)
                ->count(),
            'revenue_today' => (float) Order::query()
                ->whereNull('application_id')
                ->whereDate('created_at', $today)
                ->sum('total'),
            'queues_waiting' => Queue::query()
                ->whereDate('created_at', $today)
                ->where('status', 'В очереди')
                ->count(),
            'held_orders' => HeldOrder::query()->count(),
            'deliverer_payments' => (float) DelivererPayment::query()
                ->whereDate('created_at', $today)
                ->sum('amount'),
        ];
    }

    private function csvValue(string|int|float|null $value): string
    {
        return str_replace(["\n", "\r", ';'], ' ', trim((string) $value));
    }

    private function notifyAboutOrder(?int $userId, int $orderId, string $clientPhone, Order $order): void
    {
        try {
            $message = "📦 Салом, муштарии муҳтарам!\n\n🚚 Шумо бо муваффақият фармоиши худро қабул/дархост намудед.\n⚖️ Вазн: {$order->weight} кг\n📏 Ҳаҷм: {$order->cube} м³\n💰 Ҷамъбаст: {$order->subtotal} с\n💵 Тахфиф: {$order->discount} с\n🚛 Нархи бурда расонӣ: {$order->delivery_total} с\n✅ Ҳамагӣ: {$order->total} с\n\nТашаккур, ки бо мо ҳастед! 💚";
            if ($userId) {
                $user = User::query()
                    ->select(['id', 'chat_id'])
                    ->find($userId);

                if ($user && !empty($user->chat_id)) {
                    try {
                        $telegram = new Telegram();
                        $telegram->sms_order($user->id, $orderId);
                        return;
                    } catch (\Throwable $telegramException) {
                        report($telegramException);
                    }
                }
            }

            $phone = trim($clientPhone);
            if ($phone !== '') {
                $smsOson = new SmsController();
                $smsOson->sendSms($phone, $message);
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function updateTrackStatuses(string|int $userId, int $orderId, array $tracks): void
    {
        foreach ($tracks as $code) {
            $trimmed = trim((string) $code);
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

    private function normalizeClientCode(?string $value): string
    {
        $candidate = strtoupper(trim((string) $value));
        $candidate = str_replace(' ', '', $candidate);

        if ($candidate === '') {
            return 'SF';
        }

        if (!str_starts_with($candidate, 'SF')) {
            return 'SF' . $candidate;
        }

        return $candidate;
    }

    private function normalizePaymentType(?string $value): string
    {
        $payment = trim((string) $value);

        return in_array($payment, $this->paymentMethods(), true)
            ? $payment
            : self::DEFAULT_PAYMENT_TYPE;
    }

    private function paymentMethods(): array
    {
        return [
            self::DEFAULT_PAYMENT_TYPE,
            'Алиф',
            'Душанбе Сити',
        ];
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

    /**
     * Позволяет безопасно писать в БД, даже если часть колонок ещё не доехала миграциями.
     */
    private function filterExistingColumns(string $table, array $payload): array
    {
        static $columnsByTable = [];

        if (!isset($columnsByTable[$table])) {
            $columnsByTable[$table] = array_flip(Schema::getColumnListing($table));
        }

        $existing = $columnsByTable[$table];

        return array_filter(
            $payload,
            static fn (mixed $_, string $column): bool => isset($existing[$column]),
            ARRAY_FILTER_USE_BOTH
        );
    }
}
