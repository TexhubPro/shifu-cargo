<?php

namespace App\Livewire;

use App\Models\Expences;
use App\Models\HeldOrder;
use App\Models\Order;
use App\Models\Queue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.empty')]
class CashdeskReports extends Component
{
    public function getTodayOrdersProperty()
    {
        return Order::with(['user'])
            ->whereDate('created_at', Carbon::today())
            ->orderByDesc('created_at')
            ->get();
    }

    public function getTodayOrdersSummaryProperty(): array
    {
        $orders = $this->todayOrders;
        return [
            'count' => $orders->count(),
            'weight' => $orders->sum('weight'),
            'cube' => $orders->sum('cube'),
            'discount' => $orders->sum('discount'),
            'total' => $orders->sum('total'),
            'subtotal' => $orders->sum('subtotal'),
        ];
    }

    public function getTodayExpensesProperty()
    {
        return Expences::whereDate('created_at', Carbon::today())
            ->latest()
            ->get();
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

    public function render()
    {
        return view('livewire.cashdesk-reports');
    }

    public function downloadTodayReport()
    {
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
            'Создан',
        ];

        $lines = [implode(';', $headers)];
        foreach ($orders as $order) {
            $lines[] = implode(';', [
                $order->id,
                optional($order->user)->name ?? '—',
                optional($order->user)->phone ?? $order->user_id,
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

        return Response::streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
