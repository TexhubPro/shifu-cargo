<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Отчёты Excel</flux:heading>
        <flux:text class="text-base" variant="subtle">Скачайте отчёт за выбранный период времени.</flux:text>
    </div>
    <div class="space-y-3">
        <div class="grid grid-cols-2 gap-3">
            <flux:date-picker wire:model="from" label="Дата начала" />
            <flux:date-picker wire:model="to" label="Дата окончания" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <flux:button type="button" wire:click="downloadReportOrders" variant="primary" color="lime">
                Отчёт по заказам
            </flux:button>

            <flux:button type="button" wire:click="downloadReportExpensesAll" variant="primary" color="green">
                Все затраты
            </flux:button>

            <flux:button type="button" wire:click="downloadReportExpensesDushanbe" variant="primary" color="blue">
                Затраты склад Душанбе
            </flux:button>

            <flux:button type="button" wire:click="downloadReportExpensesIvu" variant="primary" color="orange">
                Затраты склад Иву
            </flux:button>

            <flux:button type="button" wire:click="downloadReportExpensesCubature" variant="primary" color="yellow">
                Затраты по кубатуре
            </flux:button>

            <flux:button type="button" wire:click="downloadReportClients" variant="primary" color="pink">
                Отчёт по клиентам
            </flux:button>

            <flux:button type="button" wire:click="downloadReportGeneral" variant="primary" color="red">
                Общий отчёт
            </flux:button>
        </div>

    </div>

</div>
