@php
    $monthStats = $this->monthStats;
    $ordersTotal = $monthStats['count'];
    $ordersSum = $monthStats['sum'];
    $ordersAvg = $monthStats['avg'];
    $ordersWeight = $monthStats['weight'];
@endphp

<div class="space-y-6">
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Список заказов</flux:heading>

            <flux:modal.trigger name="orders-filters">
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

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Всего заказов</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <flux:icon icon="clipboard-document-list" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">{{ $ordersTotal }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $monthStats['label'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Сумма заказов</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                        <flux:icon icon="banknotes" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($ordersSum, 2, '.', ' ') }} c</p>
                <p class="text-xs text-gray-400 mt-1">{{ $monthStats['label'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Средний чек</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                        <flux:icon icon="calculator" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($ordersAvg, 2, '.', ' ') }} c</p>
                <p class="text-xs text-gray-400 mt-1">{{ $monthStats['label'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Вес всего</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100">
                        <flux:icon icon="scale" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($ordersWeight, 2, '.', ' ') }} кг</p>
                <p class="text-xs text-gray-400 mt-1">{{ $monthStats['label'] }}</p>
            </div>
        </div>
    </div>

    <flux:modal name="orders-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры заказов</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="applyFilters">
                <flux:input icon="user" placeholder="Код клиента" clearable label="Поиск по коду"
                    wire:model.defer="searchCode" />
                <flux:input icon="phone" placeholder="Телефон" clearable label="Поиск по телефону"
                    wire:model.defer="searchPhone" />
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <flux:input type="number" min="0" step="0.01" label="Сумма от"
                        wire:model.defer="minTotal" placeholder="0" />
                    <flux:input type="number" min="0" step="0.01" label="Сумма до"
                        wire:model.defer="maxTotal" placeholder="0" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <flux:date-picker label="Дата от" wire:model.defer="dateFrom" />
                    <flux:date-picker label="Дата до" wire:model.defer="dateTo" />
                </div>
                <flux:select label="Сортировка" wire:model.defer="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="total">По сумме</flux:select.option>
                    <flux:select.option value="weight">По весу</flux:select.option>
                    <flux:select.option value="cube">По кубу</flux:select.option>
                    <flux:select.option value="subtotal">По подытогу</flux:select.option>
                    <flux:select.option value="discount">По скидке</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.defer="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>
                <flux:checkbox wire:model.defer="onlyApplicationsWithPhoto"
                    label="Только заказы по заявке с фото-отчётом"
                    description="Показывает записи, созданные из заявок и с прикреплённым файлом." />

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

    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">

        <flux:table :paginate="$this->orders">
            <flux:table.columns>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Весь</flux:table.column>
                <flux:table.column>Куб</flux:table.column>
                <flux:table.column>Подытог</flux:table.column>
                <flux:table.column>Скидка</flux:table.column>
                <flux:table.column>Итог</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->orders as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->user->code ?? $item->user_id }}</flux:table.cell>
                        <flux:table.cell>{{ $item->weight }}</flux:table.cell>
                        <flux:table.cell>{{ $item->cube }}</flux:table.cell>
                        <flux:table.cell>{{ $item->subtotal }}c</flux:table.cell>
                        <flux:table.cell>{{ $item->discount }}c</flux:table.cell>
                        <flux:table.cell>{{ $item->total }}c</flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                        </flux:table.cell>

                        @if (Auth::user()->role == 'admin')
                            <flux:table.cell>
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button variant="primary" color="blue" size="sm" square
                                        icon="eye" icon:class="!text-white" class="!text-white"
                                        href="{{ route('admin.orders.show', $item->id) }}" />

                                    <flux:modal.trigger name="confirm-order-delete">
                                        <flux:button variant="danger" size="sm" square icon="trash"
                                            icon:class="!text-white" class="!text-white"
                                            wire:click="confirmDelete({{ $item->id }})" />
                                    </flux:modal.trigger>
                                </div>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <flux:modal name="confirm-order-delete" class="md:w-[28rem]">
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <flux:icon icon="trash" variant="mini" />
                </div>

                <div class="space-y-1">
                    <flux:heading>Удалить заказ?</flux:heading>
                    <flux:text class="text-sm text-zinc-600">
                        @if ($orderToDeleteClient)
                            Будет удален заказ клиента <span class="font-semibold">{{ $orderToDeleteClient }}</span>
                            @if ($orderToDeleteTotal !== null)
                                на сумму <span
                                    class="font-semibold">{{ number_format((float) $orderToDeleteTotal, 2, '.', ' ') }}
                                    c</span>.
                            @endif
                        @endif
                        Это действие нельзя отменить.
                    </flux:text>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost" wire:click="clearDeleteSelection">Отмена</flux:button>
                </flux:modal.close>

                <flux:modal.close>
                    <flux:button variant="danger" icon="trash" wire:click="deleteSelected"
                        :disabled="$orderToDelete === null">
                        Удалить
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
