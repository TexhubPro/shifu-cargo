<?php

namespace App\Exports;

use App\Models\Expences;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExpensesCubatureExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
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
        $query = Expences::query()->whereIn('sklad', ['Кубатура Иву', 'Кубатура Душанбе']);

        if ($this->from) {
            $query->where('data', '>=', $this->from . ' 00:00:00');
        }

        if ($this->to) {
            $query->where('data', '<=', $this->to . ' 23:59:59');
        }

        return $query->select(['id', 'sklad', 'total', 'content', 'data']);
    }
    public function map($order): array
    {
        return [
            $order->id,
            $order->sklad,
            $order->total,
            $order->content,
            $order->data,
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Склад', 'Сумма', 'Описание', 'Дата'];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow(); // последняя строка с данными
                $totalRow = $highestRow + 1;          // строка для итогов

                // Суммируем колонку "Сумма" (C)
                $sheet->setCellValue("C{$totalRow}", "=SUM(C2:C{$highestRow})");

                // Подпись в колонке B
                $sheet->setCellValue("B{$totalRow}", "Итого:");

                // Жирный шрифт для итоговой строки
                $sheet->getStyle("B{$totalRow}:C{$totalRow}")->getFont()->setBold(true);

                // Дополнительно можно выровнять текст по центру
                $sheet->getStyle("B{$totalRow}:C{$totalRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
