<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Expences;
use App\Models\Trackcode;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GeneralExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;
    protected $from;
    protected $to;

    public function __construct(?string $from = null, ?string $to = null)
    {
        $this->from = $from . ' 00:00:00';
        $this->to = $to . ' 23:59:59';
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        $start = $this->from ? Carbon::parse($this->from)->startOfDay() : Carbon::parse(Order::min('created_at'))->startOfDay();
        $end = $this->to ? Carbon::parse($this->to)->endOfDay() : Carbon::parse(Order::max('created_at'))->endOfDay();

        $dates = collect();
        $current = $start->copy();

        while ($current <= $end) {
            $date = $current->format('Y-m-d');

            $orders = Order::whereDate('created_at', $date)->get();
            $clientsCount = User::whereDate('created_at', $date)->count();
            $ordersSum = $orders->sum('total');
            $deliverySum = $orders->sum('delivery_total');
            $trackCodesCount = Trackcode::whereDate('created_at', $date)->count();

            $expensesDushanbe = Expences::where('sklad', 'Склад Душанбе')
                ->whereDate('created_at', $date)->sum('total');
            $expensesIvu = Expences::where('sklad', 'Склад Иву')
                ->whereDate('created_at', $date)->sum('total');
            $expensesCubature = Expences::where('sklad', 'Кубатура')
                ->whereDate('created_at', $date)->sum('total');

            $dates->push([
                $date,
                $clientsCount,
                $ordersSum,
                $deliverySum,
                $trackCodesCount,
                $expensesDushanbe,
                $expensesIvu,
                $expensesCubature
            ]);

            $current->addDay();
        }

        return $dates;
    }


    public function headings(): array
    {
        return [
            'Дата',
            'Кол-во клиентов',
            'Сумма заказов',
            'Сумма доставки',
            'Кол-во трек-кодов',
            'Расходы Дushanbe',
            'Расходы Ivu',
            'Расходы кубатуры'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $totalRow = $highestRow + 1;

                // Суммируем колонки с числами: B-H
                foreach (range('B', 'H') as $col) {
                    $sheet->setCellValue("{$col}{$totalRow}", "=SUM({$col}2:{$col}{$highestRow})");
                }

                $sheet->setCellValue("A{$totalRow}", "Итого:");
                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->getFont()->setBold(true);
                $sheet->getStyle("A{$totalRow}:H{$totalRow}")
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
