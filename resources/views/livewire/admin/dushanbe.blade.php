<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Склад Душанбе</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Информация о товарах, прибывших или ожидающих выдачи в Душанбе.
        </flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Добавление и списание товаров</flux:heading>
            <flux:text>Работа с Excel-файлами и проверка по коду клиента.</flux:text>
        </div>

        <flux:tab.group class="mt-3">
            <flux:tabs variant="segmented">
                <flux:tab name="all">Все товары</flux:tab>
                <flux:tab name="excel">Добавить</flux:tab>
                <flux:tab name="writeoff">Списать</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="all">
                <form class="space-y-4" wire:submit="check_user">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                        <flux:input icon="magnifying-glass" placeholder="Введите трек-код" clearable
                            label="Поиск по трек-коду" wire:model.live.debounce.400ms="search" />
                        <flux:input icon="user-circle" placeholder="Специалный код клиента" clearable
                            label="Фильтр по коду клиента" wire:model.live.debounce.400ms="user_code" />

                        <flux:select label="Сортировка" wire:model.live="sortField">
                            <flux:select.option value="created_at">По дате</flux:select.option>
                            <flux:select.option value="code">По трек-коду</flux:select.option>
                            <flux:select.option value="user_id">По клиенту</flux:select.option>
                        </flux:select>
                        <flux:select label="Направление" wire:model.live="sortDirection">
                            <flux:select.option value="desc">Сначала новые</flux:select.option>
                            <flux:select.option value="asc">Сначала старые</flux:select.option>
                        </flux:select>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <flux:button variant="primary" color="lime" class="w-full sm:w-auto" type="submit">
                            Применить фильтр
                        </flux:button>
                        <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                            Найдено: {{ $this->trackcodes->total() }}
                        </span>
                    </div>
                </form>
                <div class="mt-6 flex flex-col gap-1">
                    <flux:heading>Трек-коды склада</flux:heading>
                    <flux:text>Список посылок, доступных для выдачи в Душанбе.</flux:text>
                </div>
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
                                <flux:table.cell>{{ $item->user->code }}</flux:table.cell>
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
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </flux:tab.panel>
            <flux:tab.panel name="excel">
                <form class="space-y-4" wire:submit="importExcel">
                    <flux:date-picker mode="range" label="Выберите даты рейса" wire:model="flightDates" required />
                    <flux:input type="file" wire:model="excelFile" label="Выберите Excel файл" required
                        accept=".xlsx,.xls,.csv" />
                    <flux:button variant="primary" color="lime" class="w-full lg:w-auto" type="submit">
                        Загрузить файл
                    </flux:button>
                </form>
            </flux:tab.panel>

            <flux:tab.panel name="writeoff">
                <form class="space-y-4" wire:submit.prevent="writeOffItem">
                    <flux:input type="file" wire:model="excelFilewriteOffItem" label="Выберите Excel файл" required
                        accept=".xlsx,.xls,.csv" />
                    <flux:button variant="primary" color="red" class="w-full lg:w-auto" type="submit">
                        Списать товары
                    </flux:button>
                </form>
            </flux:tab.panel>
        </flux:tab.group>
    </div>
</div>
