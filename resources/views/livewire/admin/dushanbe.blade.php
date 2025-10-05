<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Склад Душанбе</flux:heading>
        <flux:text class="text-base" variant="subtle">Информация о товарах, прибывших или ожидающих выдачи в Душанбе.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <div>
            <flux:heading>Добавление и списание товаров</flux:heading>
            <flux:text>Из Excel-файла для склада Душанбе</flux:text>

            <flux:tab.group class="mt-5">
                <flux:tabs variant="segmented">
                    <flux:tab name="all">Все товары</flux:tab>
                    <flux:tab name="excel">Добавить</flux:tab>
                    <flux:tab name="writeoff">Списать</flux:tab>
                </flux:tabs>

                <!-- 🔹 Вкладка 1: Добавление через Excel -->
                <flux:tab.panel name="all">
                    <form class="space-y-3" wire:submit="check_user">
                        <flux:input icon="user-circle" placeholder="Специалный код клиента" clearable
                            label="Специалный код клиента" wire:model="user_code" />
                        <flux:button variant="primary" color="lime" class="w-full" type="submit">
                            Проверить
                        </flux:button>
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
                    <form class="space-y-3" wire:submit="importExcel">
                        <!-- 🔹 Выбор диапазона дат рейса -->
                        <flux:date-picker mode="range" label="Выберите даты рейса" wire:model="flightDates" required />

                        <!-- 🔹 Загрузка Excel файла -->
                        <flux:input type="file" wire:model="excelFile" label="Выберите Excel файл" required
                            accept=".xlsx,.xls,.csv" />

                        <!-- 🔹 Кнопка отправки -->
                        <flux:button variant="primary" color="lime" class="w-full" type="submit">
                            Загрузить файл
                        </flux:button>
                    </form>
                </flux:tab.panel>

                <!-- 🔹 Вкладка 2: Списание товара -->
                <flux:tab.panel name="writeoff">
                    <form class="space-y-3" wire:submit.prevent="writeOffItem">
                        <flux:input type="file" wire:model="excelFilewriteOffItem" label="Выберите Excel файл" required
                            accept=".xlsx,.xls,.csv" />
                        <flux:button variant="primary" color="red" class="w-full" type="submit">
                            Списать товары
                        </flux:button>
                    </form>
                </flux:tab.panel>


            </flux:tab.group>
        </div>


    </div>
</div>