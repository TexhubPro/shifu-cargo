<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading class="text-xl">Заявки на доставку</flux:heading>
                <flux:text class="text-sm" variant="subtle">Обработка и подтверждение заявок на доставку грузов клиентам.
                </flux:text>
            </div>
            <flux:button color="red" variant="outline" wire:click="cleanInvalid" wire:confirm>
                Очистить недопустимые заявки
            </flux:button>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Фильтры и сортировка</flux:heading>
            <flux:text>Поиск заявок и управление списком.</flux:text>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <flux:input icon="user" placeholder="Имя клиента" clearable label="Поиск по имени"
                wire:model.live.debounce.400ms="searchName" />
            <flux:input icon="phone" placeholder="Телефон" clearable label="Поиск по телефону"
                wire:model.live.debounce.400ms="searchPhone" />
            <flux:select label="Статус" wire:model.live="status" placeholder="Все статусы">
                <flux:select.option value="">Все статусы</flux:select.option>
                <flux:select.option value="В ожидании">В ожидании</flux:select.option>
                <flux:select.option value="Собрано">Собрано</flux:select.option>
                <flux:select.option value="У доставщика">У доставщика</flux:select.option>
                <flux:select.option value="Доставлено">Доставлено</flux:select.option>
                <flux:select.option value="Отменено">Отменено</flux:select.option>
            </flux:select>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

            <flux:date-picker label="Дата от" wire:model.live="dateFrom" />
            <flux:date-picker label="Дата до" wire:model.live="dateTo" />
            <flux:select label="Сортировка" wire:model.live="sortField">
                <flux:select.option value="created_at">По дате</flux:select.option>
                <flux:select.option value="name">По имени</flux:select.option>
                <flux:select.option value="status">По статусу</flux:select.option>
                <flux:select.option value="phone">По телефону</flux:select.option>
            </flux:select>
            <flux:select label="Направление" wire:model.live="sortDirection">
                <flux:select.option value="desc">Сначала новые</flux:select.option>
                <flux:select.option value="asc">Сначала старые</flux:select.option>
            </flux:select>
            <flux:select label="На странице" wire:model.live="perPage" class="w-full">
                <flux:select.option value="25">25</flux:select.option>
                <flux:select.option value="50">50</flux:select.option>
                <flux:select.option value="100">100</flux:select.option>
            </flux:select>
        </div>

        <flux:table :paginate="$this->orders">
            <flux:table.columns>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Адрес</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->orders as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->user->code }}</flux:table.cell>
                        <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                        <flux:table.cell class="max-w-48 overflow-hidden truncate">{{ $item->address }}
                        </flux:table.cell>

                        <flux:table.cell>
                            @switch($item->status)
                                @case('В ожидании')
                                    <flux:badge color="orange" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Собрано')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('У доставщика')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Доставлено')
                                    <flux:badge color="emerald" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @default
                                    <flux:badge color="yellow" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                            @endswitch
                        </flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                        </flux:table.cell>
                        @if (Auth::user()->role == 'admin')
                            <flux:table.cell>
                                <div class="grid grid-cols-3 gap-2">
                                    <flux:button variant="primary" size="sm" color="red"
                                        wire:click="delete({{ $item->id }})" wire:confirm>
                                        Удалить</flux:button>
                                    <flux:button variant="primary" size="sm" color="lime"
                                        wire:click="activate({{ $item->id }})" wire:confirm>
                                        Активировать</flux:button>
                                    <flux:button size="sm" variant="outline"
                                        href="{{ route('admin.applications.show', $item->id) }}">
                                        Детали
                                    </flux:button>
                                </div>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
