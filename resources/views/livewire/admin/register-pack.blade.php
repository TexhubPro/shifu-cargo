<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Регистрация груза</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Укажите информацию о грузе для оформления в города Иву или Душанбе.
        </flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Введите необходимую информацию</flux:heading>
            <flux:text>Чтобы зарегистрировать груз — укажите вес, тип и количество коробок.</flux:text>
        </div>

        <flux:tab.group>
            <flux:tabs variant="segmented">
                <flux:tab name="excel">Город Душанбе</flux:tab>
                <flux:tab name="manual">Город Иву</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="excel">
                <form class="space-y-4" wire:submit.prevent="registerDushanbe">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <flux:date-picker label="Выберите дату" wire:model.live="data" required />
                        <flux:input icon="scale" type="number" step="0.1" label="Куб (м3)"
                            placeholder="Введите куб груза" wire:model="cube" />
                        <flux:input icon="scale" type="number" step="0.1" label="Вес (кг)"
                            placeholder="Введите вес груза" wire:model="weight" required />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <flux:select label="Тип груза" wire:model="type" placeholder="Выберите тип" required>
                            <option value="мелкий">Мелкий</option>
                            <option value="крупный">Крупный</option>
                            <option value="штучно">Штучно</option>
                        </flux:select>
                        <flux:input icon="arrows-pointing-out" type="number" label="Количество коробок"
                            placeholder="Введите число коробок" wire:model="boxes" min="1" required />
                        <div class="flex items-end">
                            <flux:button variant="primary" color="lime" class="w-full lg:w-auto" type="submit">
                                Зарегистрировать груз
                            </flux:button>
                        </div>
                    </div>
                </form>
            </flux:tab.panel>

            <flux:tab.panel name="manual">
                <form class="space-y-4" wire:submit.prevent="registerIvu">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <flux:date-picker label="Выберите дату" wire:model.live="ivudata" required />
                        <flux:input icon="scale" type="number" step="0.1" label="Куб (м3)"
                            placeholder="Введите куб груза" wire:model="ivucube" />
                        <flux:input icon="scale" type="number" step="0.1" label="Вес (кг)"
                            placeholder="Введите вес груза" wire:model="ivuweight" required />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <flux:select label="Тип груза" wire:model="ivutype" placeholder="Выберите тип" required>
                            <option value="мелкий">Мелкий</option>
                            <option value="крупный">Крупный</option>
                            <option value="штучно">Штучно</option>
                        </flux:select>
                        <flux:input icon="arrows-pointing-out" type="number" label="Количество коробок"
                            placeholder="Введите число коробок" wire:model="ivuboxes" min="1" required />
                    <div class="flex items-end">
                        <flux:button variant="primary" color="lime" class="w-full lg:w-auto" type="submit">
                            Зарегистрировать груз
                        </flux:button>
                    </div>
                </div>
            </form>
        </flux:tab.panel>
    </flux:tab.group>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
        <flux:tab.group>
            <flux:tabs variant="segmented">
                <flux:tab name="excel">Журнал Душанбе</flux:tab>
                <flux:tab name="manual">Журнал Иву</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="excel">
                <div class="flex flex-col gap-1">
                    <flux:heading>Журнал регистраций (Душанбе)</flux:heading>
                    <flux:text>Фильтруйте записи и сортируйте список.</flux:text>
                </div>

                <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <flux:input icon="magnifying-glass" placeholder="Поиск по типу, весу, кубу, коробкам"
                        label="Поиск" wire:model.live.debounce.400ms="searchDushanbe" clearable />
                    <flux:select label="Тип груза" wire:model.live="typeFilterDushanbe" placeholder="Все типы">
                        <flux:select.option value="">Все типы</flux:select.option>
                        <flux:select.option value="мелкий">Мелкий</flux:select.option>
                        <flux:select.option value="крупный">Крупный</flux:select.option>
                        <flux:select.option value="штучно">Штучно</flux:select.option>
                    </flux:select>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <flux:date-picker label="Дата от" wire:model.live="dateFromDushanbe" />
                        <flux:date-picker label="Дата до" wire:model.live="dateToDushanbe" />
                    </div>
                </div>

                <div class="mt-4 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full lg:w-auto">
                        <flux:select label="Сортировка" wire:model.live="sortFieldDushanbe">
                            <flux:select.option value="created_at">По дате записи</flux:select.option>
                            <flux:select.option value="data">По дате груза</flux:select.option>
                            <flux:select.option value="weight">По весу</flux:select.option>
                            <flux:select.option value="cube">По кубу</flux:select.option>
                            <flux:select.option value="packages">По коробкам</flux:select.option>
                            <flux:select.option value="type">По типу</flux:select.option>
                        </flux:select>
                        <flux:select label="Направление" wire:model.live="sortDirectionDushanbe">
                            <flux:select.option value="desc">Сначала новые</flux:select.option>
                            <flux:select.option value="asc">Сначала старые</flux:select.option>
                        </flux:select>
                    </div>
                    <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                        Всего: {{ $this->dushanbes->total() }}
                    </span>
                </div>

                <flux:table :paginate="$this->dushanbes" class="mt-5">
                    <flux:table.columns>
                        <flux:table.column>Склад</flux:table.column>
                        <flux:table.column>Вес груза</flux:table.column>
                        <flux:table.column>Куб груза</flux:table.column>
                        <flux:table.column>Тип груза</flux:table.column>
                        <flux:table.column>Коробки</flux:table.column>
                        <flux:table.column>Дата</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->dushanbes as $item)
                            <flux:table.row>
                                <flux:table.cell>{{ $item->sklad }}</flux:table.cell>
                                <flux:table.cell>{{ $item->weight }}кг</flux:table.cell>
                                <flux:table.cell>{{ $item->cube }}m3</flux:table.cell>
                                <flux:table.cell>{{ $item->type }}</flux:table.cell>
                                <flux:table.cell>{{ $item->packages }}шт</flux:table.cell>
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
            </flux:tab.panel>

            <flux:tab.panel name="manual">
                <div class="flex flex-col gap-1">
                    <flux:heading>Журнал регистраций (Иву)</flux:heading>
                    <flux:text>Фильтруйте записи и сортируйте список.</flux:text>
                </div>

                <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <flux:input icon="magnifying-glass" placeholder="Поиск по типу, весу, кубу, коробкам"
                        label="Поиск" wire:model.live.debounce.400ms="searchIvu" clearable />
                    <flux:select label="Тип груза" wire:model.live="typeFilterIvu" placeholder="Все типы">
                        <flux:select.option value="">Все типы</flux:select.option>
                        <flux:select.option value="мелкий">Мелкий</flux:select.option>
                        <flux:select.option value="крупный">Крупный</flux:select.option>
                        <flux:select.option value="штучно">Штучно</flux:select.option>
                    </flux:select>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <flux:date-picker label="Дата от" wire:model.live="dateFromIvu" />
                        <flux:date-picker label="Дата до" wire:model.live="dateToIvu" />
                    </div>
                </div>

                <div class="mt-4 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 w-full lg:w-auto">
                        <flux:select label="Сортировка" wire:model.live="sortFieldIvu">
                            <flux:select.option value="created_at">По дате записи</flux:select.option>
                            <flux:select.option value="data">По дате груза</flux:select.option>
                            <flux:select.option value="weight">По весу</flux:select.option>
                            <flux:select.option value="cube">По кубу</flux:select.option>
                            <flux:select.option value="packages">По коробкам</flux:select.option>
                            <flux:select.option value="type">По типу</flux:select.option>
                        </flux:select>
                        <flux:select label="Направление" wire:model.live="sortDirectionIvu">
                            <flux:select.option value="desc">Сначала новые</flux:select.option>
                            <flux:select.option value="asc">Сначала старые</flux:select.option>
                        </flux:select>
                    </div>
                    <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                        Всего: {{ $this->ivus->total() }}
                    </span>
                </div>

                <flux:table :paginate="$this->ivus" class="mt-5">
                    <flux:table.columns>
                        <flux:table.column>Склад</flux:table.column>
                        <flux:table.column>Вес груза</flux:table.column>
                        <flux:table.column>Куб груза</flux:table.column>
                        <flux:table.column>Тип груза</flux:table.column>
                        <flux:table.column>Коробки</flux:table.column>
                        <flux:table.column>Дата</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->ivus as $item)
                            <flux:table.row>
                                <flux:table.cell>{{ $item->sklad }}</flux:table.cell>
                                <flux:table.cell>{{ $item->weight }}кг</flux:table.cell>
                                <flux:table.cell>{{ $item->cube }}m3</flux:table.cell>
                                <flux:table.cell>{{ $item->type }}</flux:table.cell>
                                <flux:table.cell>{{ $item->packages }}шт</flux:table.cell>
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
            </flux:tab.panel>
        </flux:tab.group>
    </div>
</div>
