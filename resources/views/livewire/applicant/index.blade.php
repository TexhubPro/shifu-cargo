<div class="space-y-6">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <flux:heading class="text-2xl text-gray-900">Заявки на доставку</flux:heading>
            <flux:text class="mt-1 text-gray-600 max-w-xl">
                Обрабатывайте заявки, прикрепляйте фото-отчёт и оперативно оформляйте доставку.
                Пустые телефон или адрес автоматически помечаются как отменённые.
            </flux:text>
        </div>
        <div class="flex flex-wrap gap-3">
            <flux:modal.trigger name="track_lookup">
                <flux:button variant="outline" color="indigo">
                    Проверка трек-кода
                </flux:button>
            </flux:modal.trigger>
            <flux:button color="blue" wire:click="restart">Обновить</flux:button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Всего в ожидании</p>
            <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $pendingCount }}</p>
            <p class="text-gray-500 text-sm mt-1">Заявок ждут обработки</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Оформлено сегодня</p>
            <p class="text-3xl font-semibold text-emerald-600 mt-1">{{ $ordersToday }}</p>
            <p class="text-gray-500 text-sm mt-1">Заказов за текущий день</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Отменено сегодня</p>
            <p class="text-3xl font-semibold text-rose-600 mt-1">{{ $cancelledToday }}</p>
            <p class="text-gray-500 text-sm mt-1">Статус: менеджер отменил</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 text-sm text-gray-500">
            <span>На странице по 50 заявок</span>
            <span class="text-gray-400">Всего ожидает: {{ $pendingCount }}</span>
        </div>
        <div class="overflow-x-auto p-4">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column class="w-20 text-gray-700">
                        <span class="text-gray-700">#</span>
                    </flux:table.column>
                    <flux:table.column class="max-w-[160px] text-gray-700"><span class="text-gray-700">Имя</span>
                    </flux:table.column>
                    <flux:table.column class="max-w-[140px] text-gray-700"><span class="text-gray-700">Телефон</span>
                    </flux:table.column>
                    <flux:table.column class="max-w-[240px] text-gray-700"><span class="text-gray-700">Адрес</span>
                    </flux:table.column>
                    <flux:table.column class="w-48 text-right text-gray-700"><span class="text-gray-700">Действия</span>
                    </flux:table.column>
                </flux:table.columns>
                {{-- welfr --}}
                <flux:table.rows>
                    @forelse ($orders as $item)
                        <flux:table.row>
                            <flux:table.cell class="pl-3">
                                <span class="text-xs font-semibold text-gray-700">
                                    {{ str_pad($item->id, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </flux:table.cell>
                            <flux:table.cell>
                                <span class="block max-w-[160px] truncate text-gray-900"
                                    title="{{ $item->user->name }}-{{ $item->user->code ?? '-' }}">
                                    {{ $item->user->name }}-{{ $item->user->code ?? '-' }}
                                </span>
                            </flux:table.cell>
                            <flux:table.cell variant="strong">
                                <span class="block max-w-[140px] truncate text-gray-700" title="{{ $item->phone }}">
                                    {{ $item->phone }}
                                </span>
                            </flux:table.cell>
                            <flux:table.cell variant="strong">
                                <span class="block max-w-[240px] truncate text-gray-700" title="{{ $item->address }}">
                                    {{ $item->address }}
                                </span>
                            </flux:table.cell>
                            <flux:table.cell class="flex gap-2 justify-end">
                                <flux:button variant="primary" color="red" size="sm" wire:confirm
                                    wire:click="cancel({{ $item->id }})">
                                    Отменить
                                </flux:button>
                                <flux:modal.trigger name="order_place">
                                    <flux:button variant="primary" color="lime" size="sm"
                                        wire:click="select_order({{ $item->id }})">
                                        Оформить
                                    </flux:button>
                                </flux:modal.trigger>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="5">
                                <p class="text-center text-gray-500 py-4">Заявок пока нет.</p>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            {{ $orders->onEachSide(1)->links() }}
        </div>
    </div>

    <flux:modal name="track_lookup" class="w-full max-w-lg">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg" class="text-gray-900">Проверка трек-кода</flux:heading>
                <flux:text class="text-gray-600 text-sm">
                    Отсканируйте или введите трек. Результат сохранится до следующей проверки.
                </flux:text>
            </div>
            <form wire:submit.prevent="lookupTrack" class="space-y-3">
                <flux:input icon="magnifying-glass" placeholder="Введите трек-код" wire:model.defer="trackLookupCode"
                    wire:keydown.enter.prevent="lookupTrack" />
                <flux:button type="submit" variant="primary" color="lime" class="w-full">
                    Проверить
                </flux:button>
            </form>
            @php
                $trackMessagePalette = [
                    'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                    'warning' => 'bg-amber-50 text-amber-700 border border-amber-200',
                    'danger' => 'bg-rose-50 text-rose-700 border border-rose-200',
                    'info' => 'bg-white text-gray-600 border border-gray-200',
                ];
            @endphp
            @if ($trackLookupMessage)
                <div
                    class="rounded-xl px-4 py-3 text-sm font-medium {{ $trackMessagePalette[$trackLookupState] ?? $trackMessagePalette['info'] }}">
                    {{ $trackLookupMessage }}
                </div>
            @endif
            @if ($trackLookupResult)
                <div class="bg-white rounded-2xl border border-gray-200 p-4 space-y-3 shadow-sm">
                    <div class="flex items-center justify-between text-xs uppercase text-gray-500">
                        <span>Код</span>
                        <span class="text-gray-900 text-base font-semibold tracking-wide">
                            {{ $trackLookupResult['code'] }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 text-xs">Статус:</span>
                        <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold text-xs">
                            {{ $trackLookupResult['status'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 gap-2 text-xs text-gray-500">
                        <div class="flex justify-between rounded-lg bg-gray-50 p-2 border border-gray-200">
                            <span>Китай</span>
                            <span class="text-gray-900 font-semibold">{{ $trackLookupResult['china'] ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between rounded-lg bg-gray-50 p-2 border border-gray-200">
                            <span>Душанбе</span>
                            <span
                                class="text-gray-900 font-semibold">{{ $trackLookupResult['dushanbe'] ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between rounded-lg bg-gray-50 p-2 border border-gray-200">
                            <span>Клиент</span>
                            <span
                                class="text-gray-900 font-semibold">{{ $trackLookupResult['customer'] ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-gray-200 p-4 text-center text-sm text-gray-500">
                    Результат появится после проверки.
                </div>
            @endif
        </div>
    </flux:modal>

    <flux:modal name="order_place" class="w-full max-w-2xl">
        <form wire:submit="order_place" class="space-y-2">
            <div class="text-black space-y-2">
                <div class="flex items-center justify-between gap-4">
                </div>
                @if ($selected_order)
                    <div class="grid gap-2 md:grid-cols-2 text-sm text-black/90">
                        <div>
                            <p class="text-black/70">Клиент</p>
                            <p class="font-semibold">{{ $selected_order->user->name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-black/70">Телефон</p>
                            <p class="font-semibold">{{ $selected_order->phone ?? '—' }}</p>
                        </div>
                        <div class="col-span-full">
                            <p class="text-black/70">Адрес</p>
                            <p class="font-semibold truncate whitespace-normal">{{ $selected_order->address ?? '—' }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="">
                <div class="space-y-2 grid md:grid-cols-2 gap-2">
                    <div class="col-span-full">
                        <flux:input type="file" wire:model="file" class="col-span-full" label="Фото-отчёт"
                            required />
                        <div wire:loading wire:target="file" class="text-amber-300 text-sm">
                            ⏳ Файл загружается... пожалуйста, подождите
                        </div>
                    </div>
                    <flux:select wire:model="deliver_boy" label="Доставщик" required
                        placeholder="Выберите доставщика">
                        @foreach ($delivers as $deliver)
                            <flux:select.option value="{{ $deliver->id }}">{{ $deliver->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input label="Цена доставки (сомони)" placeholder="Введите стоимость доставки"
                        wire:model.live="delivery_price" type="number" min="0" />
                    <flux:input label="Вес груза (кг)" placeholder="Введите общий вес груза" wire:model.live="weight"
                        required />
                    <flux:input label="Объём груза (м³)" placeholder="Введите примерный объём"
                        wire:model.live="volume" />
                    {{-- <div class="col-span-full space-y-2">
                        <flux:label>Скидка</flux:label>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <flux:input placeholder="10" wire:model.live="discount" type="number" min="0" />
                            <flux:select wire:model.live="discountt" placeholder="Тип скидки">
                                <flux:select.option>Фиксированная</flux:select.option>
                                <flux:select.option>Процентная</flux:select.option>
                            </flux:select>
                        </div>
                        <p class="text-xs text-neutral-500">Укажите сумму или процент скидки.</p>
                    </div> --}}
                </div>
            </div>

            <div class="grid grid-cols-3 md:grid-cols-3 gap-3 text-sm">
                <div class="rounded-xl border border-gray-200 bg-white p-3">
                    <p class="text-gray-500">Подытог</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $this->total_amount }} c</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-3">
                    <p class="text-gray-500">Доставка</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $delivery_price }} c</p>
                </div>
                {{-- <div class="rounded-xl border border-gray-200 bg-white p-3">
                    <p class="text-gray-500">Скидка</p>
                    <p class="text-lg font-semibold text-amber-600">-{{ $this->discount_total }} c</p>
                </div> --}}
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-3">
                    <p class="text-gray-500">Итог к оплате</p>
                    <p class="text-xl font-semibold text-emerald-600">{{ $total_final }} c</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 mt-5">
                <flux:button type="button" variant="ghost" color="neutral"
                    wire:click="$dispatch('close-modal', { name: 'order_place' })" class="sm:flex-1">
                    Отмена
                </flux:button>
                <flux:button type="submit" variant="primary" color="lime" class="sm:flex-1"
                    wire:loading.attr="disabled">
                    Оформить заказ
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
