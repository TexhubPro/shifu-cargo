<div class="space-y-6">
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Отчёты и выгрузки</flux:heading>

            <flux:modal.trigger name="analitic-filters">
                <flux:button variant="primary" color="lime" square size="base" class="shrink-0 !text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-adjustments">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M6 3a1 1 0 0 1 .993 .883l.007 .117v3.171a3.001 3.001 0 0 1 0 5.658v7.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-7.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-3.17a1 1 0 0 1 1 -1z" />
                        <path
                            d="M12 3a1 1 0 0 1 .993 .883l.007 .117v9.171a3.001 3.001 0 0 1 0 5.658v1.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-1.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-9.17a1 1 0 0 1 1 -1z" />
                        <path
                            d="M18 3a1 1 0 0 1 .993 .883l.007 .117v.171a3.001 3.001 0 0 1 0 5.658v10.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-10.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-.17a1 1 0 0 1 1 -1z" />
                    </svg>
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <flux:modal name="analitic-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры отчётов</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="applyFilters">
                <flux:date-picker wire:model.defer="from" label="Дата начала" />
                <flux:date-picker wire:model.defer="to" label="Дата окончания" />
                <div class="text-xs text-gray-500 bg-slate-50 px-4 py-2 rounded-xl">
                    Период:
                    {{ $from ? \Carbon\Carbon::parse($from)->format('d.m.Y') : '—' }}
                    —
                    {{ $to ? \Carbon\Carbon::parse($to)->format('d.m.Y') : '—' }}
                </div>

                <div class="grid grid-cols-1 gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="primary" color="lime" class="w-full" type="button"
                            wire:click="applyFilters">
                            Применить фильтр
                        </flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>


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
