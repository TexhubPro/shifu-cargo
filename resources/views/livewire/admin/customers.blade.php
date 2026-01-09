<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Клиенты и коды</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Список клиентов и их зарегистрированные коды для отслеживания грузов.
        </flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Информация о клиентах</flux:heading>
            <flux:text>Поиск, фильтрация и сортировка клиентов.</flux:text>
        </div>

        <form class="space-y-4" wire:submit.prevent="check_user">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <flux:input icon="user" placeholder="Введите имя" clearable label="Поиск по имени"
                    wire:model.live.debounce.400ms="nameSearch" />
                <flux:input icon="phone" placeholder="Введите телефон" clearable label="Поиск по телефону"
                    wire:model.live.debounce.400ms="phoneSearch" />
                <flux:input placeholder="Введите код" clearable label="Поиск по коду"
                    wire:model.live.debounce.400ms="codeSearch" />
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                <flux:select label="Пол" wire:model.live="sex" placeholder="Все">
                    <flux:select.option value="">Все</flux:select.option>
                    <flux:select.option value="m">Мужской</flux:select.option>
                    <flux:select.option value="z">Женский</flux:select.option>
                </flux:select>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <flux:date-picker label="Дата от" wire:model.live="dateFrom" />
                    <flux:date-picker label="Дата до" wire:model.live="dateTo" />
                </div>
                <flux:select label="Сортировка" wire:model.live="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="name">По имени</flux:select.option>
                    <flux:select.option value="code">По коду</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.live="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>
                <flux:select label="На странице" wire:model.live="perPage">
                    <flux:select.option value="25">25</flux:select.option>
                    <flux:select.option value="50">50</flux:select.option>
                    <flux:select.option value="100">100</flux:select.option>
                </flux:select>
                <div class="flex items-end">
                    <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                        Показано: {{ $this->customers->count() }}
                    </span>
                </div>
            </div>
        </form>

        <flux:table :paginate="$this->customers" class="mt-5">
            <flux:table.columns>
                <flux:table.column>Код</flux:table.column>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Пол</flux:table.column>
                <flux:table.column>Дата присоеденения</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->customers as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->code }}</flux:table.cell>
                        <flux:table.cell>{{ $item->name }}</flux:table.cell>
                        <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                        <flux:table.cell>{{ $item->sex == 'z' ? 'Женский' : 'Мужской' }}</flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                        </flux:table.cell>
                        @if (Auth::user()->role == 'admin')
                            <flux:table.cell>
                                <flux:button variant="primary" size="sm" color="red"
                                    wire:click="delete({{ $item->id }})" wire:confirm>
                                    Удалить</flux:button>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>
