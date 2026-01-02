<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApplicationsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $from;
    protected $to;

    public function __construct(?string $from = null, ?string $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        $query = Application::query()
            ->with([
                'user:id,code,name,phone',
                'order:id,application_id,deliver_id,subtotal,discount,delivery_total,total,status,created_at',
                'order.deliver:id,name',
            ]);

        if ($this->from) {
            $query->where('created_at', '>=', $this->from . ' 00:00:00');
        }

        if ($this->to) {
            $query->where('created_at', '<=', $this->to . ' 23:59:59');
        }

        $query->whereHas('order');

        return $query->select(['id', 'user_id', 'phone', 'address', 'status', 'created_at']);
    }

    public function map($application): array
    {
        $order = $application->order;

        return [
            $application->id,
            $application->user?->code ?? '—',
            $application->user?->name ?? '—',
            $application->phone ?? '—',
            $application->address ?? '—',
            $application->status ?? '—',
            $application->created_at->timezone('Asia/Tashkent')->format('Y-m-d H:i'),
            $order?->deliver?->name ?? '—',
            $order?->subtotal ?? 0,
            $order?->discount ?? 0,
            $order?->delivery_total ?? 0,
            $order?->total ?? 0,
            $order?->status ?? '—',
            optional($order?->created_at)->timezone('Asia/Tashkent')->format('Y-m-d H:i'),
        ];
    }

    public function headings(): array
    {
        return [
            'ID заявки',
            'Код клиента',
            'Имя клиента',
            'Телефон',
            'Адрес',
            'Статус заявки',
            'Дата заявки',
            'Доставщик',
            'Подытог',
            'Скидка',
            'Доставка',
            'Итог',
            'Статус заказа',
            'Дата заказа',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $totalRow = $highestRow + 1;

                // Итого по подытогу/скидке/доставке/итогу (I-L)
                $sheet->setCellValue("I{$totalRow}", "=SUM(I2:I{$highestRow})");
                $sheet->setCellValue("J{$totalRow}", "=SUM(J2:J{$highestRow})");
                $sheet->setCellValue("K{$totalRow}", "=SUM(K2:K{$highestRow})");
                $sheet->setCellValue("L{$totalRow}", "=SUM(L2:L{$highestRow})");
                $sheet->setCellValue("H{$totalRow}", "Итого:");

                $sheet->getStyle("H{$totalRow}:L{$totalRow}")->getFont()->setBold(true);
            },
        ];
    }
}
