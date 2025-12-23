<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Трек-коды</flux:heading>
        <flux:text class="text-sm" variant="subtle">Просмотр, фильтрация и обновление трек-кодов клиентов.</flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Проверка трек-кодов</flux:heading>
            <flux:text>Отслеживайте статус и управляйте списком трек-кодов.</flux:text>
        </div>

        <form class="space-y-4 grid" wire:submit.prevent="search_form">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                <flux:input icon="qr-code" placeholder="Введите трек-код" clearable label="Поиск по трек-коду"
                    wire:model.live.debounce.400ms="search" />
                <flux:input icon="user-circle" placeholder="Код клиента" clearable label="Поиск по коду клиента"
                    wire:model.live.debounce.400ms="user_code" />
                <flux:select label="Статус" wire:model.live="status" placeholder="Все статусы">
                    <flux:select.option value="">Все статусы</flux:select.option>
                    <flux:select.option value="В ожидании">В ожидании</flux:select.option>
                    <flux:select.option value="Получено в Иву">Получено в Иву</flux:select.option>
                    <flux:select.option value="В пункте выдачи">В пункте выдачи</flux:select.option>
                    <flux:select.option value="Получено">Получено</flux:select.option>
                </flux:select>
                <flux:select label="Сортировка" wire:model.live="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="code">По трек-коду</flux:select.option>
                    <flux:select.option value="status">По статусу</flux:select.option>
                    <flux:select.option value="user_id">По клиенту</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.live="sortDirection" class="w-full">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>
            </div>
            <div class="flex items-center gap-2 justify-between">
                <flux:button variant="primary" color="lime" class="w-full sm:w-auto" type="button"
                    wire:click="checkUser">
                    Применить фильтр
                </flux:button>
                <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                    Всего: {{ $this->trackcodes->total() }}
                </span>
            </div>

        </form>

        <flux:table :paginate="$this->trackcodes" class="mt-5">
            <flux:table.columns>
                <flux:table.column>Трек-код</flux:table.column>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата получения</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->trackcodes as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->code }}</flux:table.cell>
                        <flux:table.cell>{{ $item->user->code ?? 'Не известно' }}</flux:table.cell>
                        <flux:table.cell>
                            @switch($item->status)
                                @case('В ожидании')
                                    <flux:badge color="orange" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Получено в Иву')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('В пункте выдачи')
                                    <flux:badge color="blue" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Получено')
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
