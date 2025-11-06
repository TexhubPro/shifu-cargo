<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrdersExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $from;
    protected $to;

    public function __construct(?string $from = null, ?string $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    // Используем Query — экономно при больших данных
    public function query()
    {
        $query = Order::query()->with('user:id,name,phone');

        if ($this->from) {
            $query->where('created_at', '>=', $this->from . ' 00:00:00');
        }

        if ($this->to) {
            $query->where('created_at', '<=', $this->to . ' 23:59:59');
        }

        return $query->select(['id', 'user_id', 'deliver_id', 'subtotal', 'discount', 'delivery_total', 'total', 'status', 'created_at']);
    }
    public function map($order): array
    {
        return [
            $order->id,
            $order->user?->name ?? '—',
            $order->user?->phone ?? '-',
            $order->deliver?->name ?? '—',
            $order->subtotal,
            $order->discount,
            $order->delivery_total,
            $order->total,
            $order->status,
            $order->created_at->timezone('Asia/Tashkent')->format('Y-m-d H:i'),
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Имя', 'Номер телефон', 'Доставщик', 'Подытог', 'Скидка', 'Сумма доставка', 'Итог', 'Статус', 'Дата создания'];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow(); // номер последней строки с данными

                // Итоговая строка будет после последней
                $totalRow = $highestRow + 1;

                // Суммируем колонки:
                // E = subtotal, F = discount, G = delivery_total, H = total
                $sheet->setCellValue("E{$totalRow}", "=SUM(E2:E{$highestRow})");
                $sheet->setCellValue("F{$totalRow}", "=SUM(F2:F{$highestRow})");
                $sheet->setCellValue("G{$totalRow}", "=SUM(G2:G{$highestRow})");
                $sheet->setCellValue("H{$totalRow}", "=SUM(H2:H{$highestRow})");

                // Можно добавить подпись
                $sheet->setCellValue("D{$totalRow}", "Итого:");

                // Жирный шрифт для итоговой строки
                $sheet->getStyle("D{$totalRow}:H{$totalRow}")->getFont()->setBold(true);
            },
        ];
    }
}
