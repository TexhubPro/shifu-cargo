<div class="">
    <div class="mb-5">
        <flux:heading class="text-xl">Панель управления</flux:heading>
        <flux:text class="text-base" variant="subtle">Основной раздел для контроля и навигации по системе.</flux:text>

    </div>
    @if (Auth::user()->role == 'admin')
    <div class="bg-white p-3 mb-5 rounded-xl space-y-3">

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3  items-end">
            <flux:date-picker wire:model.live="start" label="Начальная дата" />
            <flux:date-picker wire:model.live="end" label="Конечная дата" />
            <flux:button variant="primary" color="lime" wire:click="update" class="col-span-full lg:col-span-1">
                Применить
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">


        <flux:modal.trigger name="newclients">
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Новые клиенты за выбранный период</p>
                        <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $newClients->count() }}</h3>
                    </div>
                    <div class="bg-blue-100 p-2 rounded-lg text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                        </svg>
                    </div>
                </div>
            </div>
        </flux:modal.trigger>
        <a href="{{ route('admin.trackcodes') }}"
            class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Полученные трек-коды на складе Иву</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $trackcodes}}</h3>
                </div>
                <div class="bg-green-100 p-2 rounded-lg text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-barcode">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M8 13h1v3h-1z" />
                        <path d="M12 13v3" />
                        <path d="M15 13h1v3h-1z" />
                    </svg>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.orders') }}"
            class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Заработок за выбранный период</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $earnings->sum('total') }} с</h3>
                </div>
                <div class="bg-purple-100 p-2 rounded-lg text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-receipt-dollar">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                        <path d="M14.8 8a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                        <path d="M12 6v10" />
                    </svg>
                </div>
            </div>
        </a>
        <flux:modal.trigger name="allexpanses">
            <div
                class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-amber-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Все затраты за выбранный период</p>
                        <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $expenses->sum('total') }} с</h3>
                    </div>
                    <div class="bg-amber-100 p-2 rounded-lg text-amber-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-dollar">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                            <path d="M16 3v4" />
                            <path d="M8 3v4" />
                            <path d="M4 11h12.5" />
                            <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                            <path d="M19 21v1m0 -8v1" />
                        </svg>
                    </div>
                </div>
            </div>
        </flux:modal.trigger>

        <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-red-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Заработок от доставки</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $delivery->sum('delivery_total') }} с</h3>
                </div>
                <div class="bg-red-100 p-2 rounded-lg text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                        <path d="M3 9l4 0" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Чистая прибыль за выбранный период</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $netProfit }} с</h3>
                </div>
                <div class="bg-yellow-100 p-2 rounded-lg text-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-file-analytics">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M9 17l0 -5" />
                        <path d="M12 17l0 -1" />
                        <path d="M15 17l0 -3" />
                    </svg>
                </div>
            </div>
        </div>
        <flux:modal.trigger name="dushanbe">
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-pink-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Затраты на складе в Душанбе</p>
                        <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $expensesDushanbe->sum('total') }} с</h3>
                    </div>
                    <div class="bg-pink-100 p-2 rounded-lg text-pink-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21v-13l9 -4l9 4v13" />
                            <path d="M13 13h4v8h-10v-6h6" />
                            <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                        </svg>
                    </div>
                </div>
            </div>
        </flux:modal.trigger>
        <flux:modal.trigger name="ivu">
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-sky-500">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Затраты на складе в Иву</p>
                        <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $expensesIvu->sum('total') }} с</h3>
                    </div>
                    <div class="bg-sky-100 p-2 rounded-lg text-sky-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21v-13l9 -4l9 4v13" />
                            <path d="M13 13h4v8h-10v-6h6" />
                            <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                        </svg>
                    </div>
                </div>
            </div>
        </flux:modal.trigger>

        <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Затраты на кубатуре в Китае</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $cubChina->sum('total') }} с</h3>
                </div>
                <div class="bg-blue-100 p-2 rounded-lg text-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-packages">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                        <path d="M2 13.5v5.5l5 3" />
                        <path d="M7 16.545l5 -3.03" />
                        <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                        <path d="M12 19l5 3" />
                        <path d="M17 16.5l5 -3" />
                        <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" />
                        <path d="M7 5.03v5.455" />
                        <path d="M12 8l5 -3" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Затраты на кубатуре в Таджикистане</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $cubTj->sum('total') }} c</h3>
                </div>
                <div class="bg-green-100 p-2 rounded-lg text-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-packages">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                        <path d="M2 13.5v5.5l5 3" />
                        <path d="M7 16.545l5 -3.03" />
                        <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                        <path d="M12 19l5 3" />
                        <path d="M17 16.5l5 -3" />
                        <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" />
                        <path d="M7 5.03v5.455" />
                        <path d="M12 8l5 -3" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Отправленный груз из Китая</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $shipped->sum('weight') }} кг - {{
                        $shipped->sum('cube') }} m3</h3>
                </div>
                <div class="bg-purple-100 p-2 rounded-lg text-purple-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-cube-send">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M16 12.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                        <path d="M11 9.5v5.5l5 3" />
                        <path d="M16 12.545l5 -3.03" />
                        <path d="M7 9h-5" />
                        <path d="M7 12h-3" />
                        <path d="M7 15h-1" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow border-l-4 border-amber-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Полученный груз в Таджикистане</p>
                    <h3 class="text-2xl font-bold mt-1 text-gray-800">{{ $received->sum('weight') }} кг - {{
                        $received->sum('cube') }} m3</h3>
                </div>
                <div class="bg-amber-100 p-2 rounded-lg text-amber-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-checklist">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" />
                        <path d="M14 19l2 2l4 -4" />
                        <path d="M9 8h4" />
                        <path d="M9 12h2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif
    <flux:modal name="newclients" class="md:w-full">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Спец код</flux:table.column>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Телефон</flux:table.column>
                <flux:table.column>Поль</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($newClients as $item)

                <flux:table.row>
                    <flux:table.cell>{{ $item->code ?? "-"}}</flux:table.cell>
                    <flux:table.cell>{{ $item->name?? "-" }}</flux:table.cell>
                    <flux:table.cell>
                        {{ $item->phone ?? "-" }}
                    </flux:table.cell>
                    <flux:table.cell variant="strong">{{ $item->sex == "m" ? "Муж":"Жен" }}</flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
    <flux:modal name="allexpanses" class="md:w-full">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Склад \ Кубатура</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($expenses as $item)

                <flux:table.row>
                    <flux:table.cell>{{ $item->total ?? "-"}}с</flux:table.cell>
                    <flux:table.cell>{{ $item->sklad?? "-" }}</flux:table.cell>
                    <flux:table.cell>{{ $item->content ?? "-" }}</flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
    <flux:modal name="dushanbe" class="md:w-full">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Склад \ Кубатура</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($expensesDushanbe as $item)

                <flux:table.row>
                    <flux:table.cell>{{ $item->total ?? "-"}}с</flux:table.cell>
                    <flux:table.cell>{{ $item->sklad?? "-" }}</flux:table.cell>
                    <flux:table.cell>{{ $item->content ?? "-" }}</flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
    <flux:modal name="ivu" class="md:w-full">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Склад \ Кубатура</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($expensesIvu as $item)

                <flux:table.row>
                    <flux:table.cell>{{ $item->total ?? "-"}}с</flux:table.cell>
                    <flux:table.cell>{{ $item->sklad?? "-" }}</flux:table.cell>
                    <flux:table.cell>{{ $item->content ?? "-" }}</flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
</div>