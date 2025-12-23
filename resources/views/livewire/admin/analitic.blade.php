<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Отчёты и выгрузки</flux:heading>
        <flux:text class="text-sm" variant="subtle">Выберите период и скачайте нужные Excel‑отчёты.</flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full lg:w-auto">
                <flux:date-picker wire:model="from" label="Дата начала" />
                <flux:date-picker wire:model="to" label="Дата окончания" />
            </div>
            <div class="text-xs text-gray-500 bg-slate-50 px-4 py-2 rounded-xl">
                Период: {{ \Carbon\Carbon::parse($from)->format('d.m.Y') }} —
                {{ \Carbon\Carbon::parse($to)->format('d.m.Y') }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <p class="text-sm font-semibold text-gray-700">Заказы и клиенты</p>
            <p class="text-xs text-gray-400 mt-1">Продажи, доставки и список клиентов.</p>
            <div class="mt-4 space-y-2">
                <flux:button type="button" wire:click="downloadReportOrders" variant="primary" color="lime"
                    class="w-full">
                    Отчёт по заказам
                </flux:button>
                <flux:button type="button" wire:click="downloadReportClients" variant="primary" color="pink"
                    class="w-full">
                    Отчёт по клиентам
                </flux:button>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <p class="text-sm font-semibold text-gray-700">Затраты</p>
            <p class="text-xs text-gray-400 mt-1">Общие и по складам.</p>
            <div class="mt-4 space-y-2">
                <flux:button type="button" wire:click="downloadReportExpensesAll" variant="primary" color="green"
                    class="w-full">
                    Все затраты
                </flux:button>
                <flux:button type="button" wire:click="downloadReportExpensesDushanbe" variant="primary" color="blue"
                    class="w-full">
                    Затраты склад Душанбе
                </flux:button>
                <flux:button type="button" wire:click="downloadReportExpensesIvu" variant="primary" color="orange"
                    class="w-full">
                    Затраты склад Иву
                </flux:button>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <p class="text-sm font-semibold text-gray-700">Сводный блок</p>
            <p class="text-xs text-gray-400 mt-1">Кубатура и общий отчёт.</p>
            <div class="mt-4 space-y-2">
                <flux:button type="button" wire:click="downloadReportExpensesCubature" variant="primary" color="yellow"
                    class="w-full">
                    Затраты по кубатуре
                </flux:button>
                <flux:button type="button" wire:click="downloadReportGeneral" variant="primary" color="red"
                    class="w-full">
                    Общий отчёт
                </flux:button>
            </div>
        </div>
    </div>
</div>
