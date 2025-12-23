@php
    $monthStats = $this->monthStats;
    $ordersTotal = $monthStats['count'];
    $ordersSum = $monthStats['sum'];
    $ordersAvg = $monthStats['avg'];
    $ordersWeight = $monthStats['weight'];
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Список заказов</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Отслеживайте заказы, фильтруйте записи и контролируйте ключевые показатели.
        </flux:text>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Всего заказов</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ $ordersTotal }}</p>
            <p class="text-xs text-gray-400 mt-1">Месяц {{ $monthStats['label'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Сумма заказов</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ number_format($ordersSum, 2, '.', ' ') }} c</p>
            <p class="text-xs text-gray-400 mt-1">Месяц {{ $monthStats['label'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Средний чек</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ number_format($ordersAvg, 2, '.', ' ') }} c</p>
            <p class="text-xs text-gray-400 mt-1">Месяц {{ $monthStats['label'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Вес всего</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ number_format($ordersWeight, 2, '.', ' ') }} кг</p>
            <p class="text-xs text-gray-400 mt-1">Месяц {{ $monthStats['label'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Фильтры и сортировка</flux:heading>
            <flux:text>Поиск по коду клиента и телефону, фильтр по сумме и датам.</flux:text>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <flux:input icon="user" placeholder="Код клиента" clearable label="Поиск по коду"
                wire:model.live.debounce.400ms="searchCode" />
            <flux:input icon="phone" placeholder="Телефон" clearable label="Поиск по телефону"
                wire:model.live.debounce.400ms="searchPhone" />
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <flux:input type="number" min="0" step="0.01" label="Сумма от" wire:model.live="minTotal"
                    placeholder="0" />
                <flux:input type="number" min="0" step="0.01" label="Сумма до" wire:model.live="maxTotal"
                    placeholder="0" />
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <flux:date-picker label="Дата от" wire:model.live="dateFrom" />
                <flux:date-picker label="Дата до" wire:model.live="dateTo" />
            </div>
            <flux:select label="Сортировка" wire:model.live="sortField">
                <flux:select.option value="created_at">По дате</flux:select.option>
                <flux:select.option value="total">По сумме</flux:select.option>
                <flux:select.option value="weight">По весу</flux:select.option>
                <flux:select.option value="cube">По кубу</flux:select.option>
                <flux:select.option value="subtotal">По подытогу</flux:select.option>
                <flux:select.option value="discount">По скидке</flux:select.option>
            </flux:select>
            <flux:select label="Направление" wire:model.live="sortDirection">
                <flux:select.option value="desc">Сначала новые</flux:select.option>
                <flux:select.option value="asc">Сначала старые</flux:select.option>
            </flux:select>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <flux:select label="На странице" wire:model.live="perPage" class="w-full sm:w-48">
                <flux:select.option value="25">25</flux:select.option>
                <flux:select.option value="50">50</flux:select.option>
                <flux:select.option value="100">100</flux:select.option>
            </flux:select>
            <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                Всего: {{ $this->orders->total() }}
            </span>
        </div>

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
                            <flux:table.cell class="grid grid-cols-2 gap-2">
                                <flux:button variant="primary" size="sm" color="red"
                                    wire:click="delete({{ $item->id }})" wire:confirm>
                                    Удалить</flux:button>
                                <flux:button size="sm" variant="outline"
                                    href="{{ route('admin.orders.show', $item->id) }}">
                                    Детали
                                </flux:button>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
