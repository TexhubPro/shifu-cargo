<div class="min-h-screen bg-neutral-950 py-6 text-neutral-100">
    <div class="max-w-5xl mx-auto space-y-6 px-4">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <flux:heading class="text-2xl text-white">Заявки на доставку</flux:heading>
                <flux:text class="mt-1 text-neutral-300 max-w-xl">
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
                <flux:button variant="filled" color="lime" wire:click="restart">Обновить</flux:button>
                <flux:button variant="danger" color="red" wire:click="logout" wire:confirm>Выйти</flux:button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
                <p class="text-xs uppercase text-neutral-400 tracking-wide">Всего в ожидании</p>
                <p class="text-3xl font-semibold text-white mt-1">{{ $orders->count() }}</p>
                <p class="text-neutral-400 text-sm mt-1">Заявок ждут обработки</p>
            </div>
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
                <p class="text-xs uppercase text-neutral-400 tracking-wide">Готовы к оформлению</p>
                <p class="text-3xl font-semibold text-emerald-400 mt-1">
                    {{ $orders->whereNotNull('phone')->where('phone', '!=', '')->whereNotNull('address')->where('address', '!=', '')->count() }}
                </p>
                <p class="text-neutral-400 text-sm mt-1">Контакты заполнены</p>
            </div>
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
                <p class="text-xs uppercase text-neutral-400 tracking-wide">Совет кассиру</p>
                <p class="text-neutral-300 text-sm mt-1">
                    Следите за фото-отчётами: их можно прикрепить при оформлении заказа.
                </p>
            </div>
        </div>

        <div class="bg-neutral-900 rounded-2xl border border-neutral-800 shadow-lg shadow-black/40 overflow-hidden p-3">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>#</flux:table.column>
                    <flux:table.column>Имя</flux:table.column>
                    <flux:table.column>Телефон</flux:table.column>
                    <flux:table.column>Адрес</flux:table.column>
                    <flux:table.column>Действия</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($orders as $item)
                        <flux:table.row>
                            <flux:table.cell class="pl-3">
                                <span
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-neutral-700 bg-neutral-800 text-xs font-semibold text-neutral-200">
                                    {{ str_pad($item->id, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </flux:table.cell>
                            <flux:table.cell>{{ $item->user->name }}</flux:table.cell>
                            <flux:table.cell variant="strong">{{ $item->phone }}</flux:table.cell>
                            <flux:table.cell variant="strong">{{ $item->address }}</flux:table.cell>
                            <flux:table.cell class="flex gap-2">
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
                                <p class="text-center text-neutral-400 py-4">Заявок пока нет.</p>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>
    </div>

    <flux:modal name="track_lookup" class="w-full max-w-lg">
        <div class="space-y-4">
            <div
                class="bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500 rounded-2xl p-4 text-white shadow-lg shadow-indigo-900/50">
                <flux:heading size="lg" class="text-white">Проверка трек-кода</flux:heading>
                <flux:text class="text-white/80 text-sm">
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
                    'success' => 'bg-emerald-500/10 text-emerald-200 border border-emerald-500/30',
                    'warning' => 'bg-amber-500/10 text-amber-200 border border-amber-500/30',
                    'danger'  => 'bg-rose-500/10 text-rose-200 border border-rose-500/30',
                    'info'    => 'bg-neutral-900 text-neutral-300 border border-neutral-800',
                ];
            @endphp
            @if ($trackLookupMessage)
                <div
                    class="rounded-xl px-4 py-3 text-sm font-medium {{ $trackMessagePalette[$trackLookupState] ?? $trackMessagePalette['info'] }}">
                    {{ $trackLookupMessage }}
                </div>
            @endif
            @if ($trackLookupResult)
                <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 space-y-3 shadow-inner shadow-black/20">
                    <div class="flex items-center justify-between text-xs uppercase text-neutral-500">
                        <span>Код</span>
                        <span class="text-neutral-100 text-base font-semibold tracking-wide">
                            {{ $trackLookupResult['code'] }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-neutral-400 text-xs">Статус:</span>
                        <span class="px-2 py-1 rounded-full bg-emerald-500/10 text-emerald-300 font-semibold text-xs">
                            {{ $trackLookupResult['status'] }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 gap-2 text-xs text-neutral-400">
                        <div class="flex justify-between rounded-lg bg-neutral-900/60 p-2 border border-neutral-800">
                            <span>Китай</span>
                            <span class="text-neutral-100 font-semibold">{{ $trackLookupResult['china'] ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between rounded-lg bg-neutral-900/60 p-2 border border-neutral-800">
                            <span>Душанбе</span>
                            <span class="text-neutral-100 font-semibold">{{ $trackLookupResult['dushanbe'] ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between rounded-lg bg-neutral-900/60 p-2 border border-neutral-800">
                            <span>Клиент</span>
                            <span class="text-neutral-100 font-semibold">{{ $trackLookupResult['customer'] ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-neutral-800 p-4 text-center text-sm text-neutral-500">
                    Результат появится после проверки.
                </div>
            @endif
        </div>
    </flux:modal>

    <flux:modal name="order_place" class="w-full max-w-md">
        <div class="bg-neutral-900 text-neutral-100 rounded-2xl border border-neutral-800 p-4 space-y-4">
            <form wire:submit="order_place" class="space-y-4">
                <div class="space-y-1">
                    <flux:input type="file" wire:model="file" label="Фото-отчёт" required />
                    <div wire:loading wire:target="file" class="text-blue-300 text-sm">
                        ⏳ Файл загружается... пожалуйста, подождите
                    </div>
                </div>
                <flux:select wire:model="deliver_boy" label="Доставщик" required placeholder="Выберите доставщика">
                    @foreach ($delivers as $deliver)
                        <flux:select.option>{{ $deliver->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input label="Цена доставки (сомони)" placeholder="Введите стоимость доставки"
                    wire:model.live="delivery_price" type="number" min="0" />
                <flux:input label="Вес груза (кг)" placeholder="Введите общий вес груза" wire:model.live="weight"
                    required />
                <flux:input label="Объём груза (м³)" placeholder="Введите примерный объём" wire:model.live="volume" />
                <flux:select wire:model.live="payment_type" placeholder="Выберите тип оплаты" label="Тип оплаты"
                    required>
                    <flux:select.option>Алиф Моби</flux:select.option>
                    <flux:select.option>Душанбе Сити</flux:select.option>
                    <flux:select.option>Наличными</flux:select.option>
                </flux:select>
                <flux:input label="Итоговая сумма (сомони)" placeholder="Введите общую сумму"
                    wire:model.live="total_amount" type="number" min="0" required />
                <div class="space-y-1">
                    <flux:label>Скидка</flux:label>
                    <div class="flex gap-2">
                        <flux:input placeholder="10" wire:model.live="discount" type="number" min="0" />
                        <flux:select wire:model="industry" placeholder="Choose discount..."
                            wire:model.live="discountt">
                            <flux:select.option>Фиксированная</flux:select.option>
                            <flux:select.option>Процентная</flux:select.option>
                        </flux:select>
                    </div>
                </div>
                <div class="grid gap-2 text-neutral-300 text-sm">
                    <span>Подытог: {{ $this->total_amount }}c</span>
                    <span>Цена доставка: {{ $delivery_price }}c</span>
                    <span>Скидка: {{ $this->discount_total }}c</span>
                    <span class="font-semibold text-emerald-400">Итог: {{ $total_final }}c</span>
                </div>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                        Оформить заказ
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
