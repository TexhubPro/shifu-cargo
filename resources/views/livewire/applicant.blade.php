<div class="max-w-sm mx-auto p-4">
    <div class="grid grid-cols-2 gap-3 mb-4">
        <flux:button variant="filled" size="xs" wire:click="restart">Обновить</flux:button>
        <flux:button variant="danger" size="xs" wire:click="logout" wire:confirm>Выйти</flux:button>
    </div>
    <div class="flex gap-2">
        <div>
            <flux:heading class="text-xl">Заявки на доставку</flux:heading>
            <flux:text class="mt-2 max-w-60">
                Здесь отображается заявки на доставку!
            </flux:text>
        </div>
    </div>
    <div>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>#</flux:table.column>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Тел</flux:table.column>
                <flux:table.column>Адрес</flux:table.column>
                <flux:table.column>Действия</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($orders as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->id }}</flux:table.cell>
                        <flux:table.cell>{{ $item->user->name }}</flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->phone }}</flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->address }}</flux:table.cell>
                        <flux:table.cell variant="strong" class="flex gap-2">
                            <flux:button variant="primary" color="red" size="sm" wire:confirm
                                wire:click="cancel({{ $item->id }})">
                                Отменить</flux:button>
                            <flux:modal.trigger name="order_place">
                                <flux:button variant="primary" color="lime" size="sm"
                                    wire:click="select_order({{ $item->id }})">Оформить</flux:button>
                            </flux:modal.trigger>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
    <flux:modal name="order_place" class="md:w-96">
        {{-- <div class="space-y-3">
            <form wire:submit="addTrack">
                <flux:input icon="qr-code" label="Сканируйте" wire:model="newTrack"
                    placeholder="Трек-код или штрих код груза" />
            </form>
            <div class=" rounded-lg bg-white  p-2 my-4">
                @if ($tracks)
                    @foreach ($tracks as $index => $track)
                        <div class="text-lg flex justify-between items-center">
                            <span>{{ $track }}</span>
                            <button type="button" wire:click="removeTrack({{ $index }})" class="text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @else
                    <flux:text variant="subtle">Трек-коды ещё не добавлены.</flux:text>
                @endif
            </div>
        </div> --}}
        <form wire:submit="order_place" class="space-y-3">
            <flux:input type="file" wire:model="file" label="Фото отчеть" required />
            <div wire:loading wire:target="file" class="text-blue-600 text-sm">
                ⏳ Файл загружается... пожалуйста, подождите
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
            <flux:select wire:model.live="payment_type" placeholder="Выберите тип оплаты" label="Тип оплаты" required>
                <flux:select.option>Алиф Моби</flux:select.option>
                <flux:select.option>Душанбе Сити</flux:select.option>
                <flux:select.option>Наличными</flux:select.option>
            </flux:select>

            <flux:input label="Итоговая сумма (сомони)" placeholder="Введите общую сумму" wire:model.live="total_amount"
                type="number" min="0" required />
            <flux:label>Скидка</flux:label>
            <div class="flex gap-2">
                <flux:input placeholder="10" wire:model.live="discount" type="number" min="0" />

                <flux:select wire:model="industry" placeholder="Choose industry..." wire:model.live="discountt">
                    <flux:select.option>Фиксированная</flux:select.option>
                    <flux:select.option>Процентная</flux:select.option>
                </flux:select>
            </div>
            <div class="grid gap-2 text-white">
                <span>Подытог: {{ $this->total_amount }}c</span>
                <span>Цена доставка: {{ $delivery_price }}c</span>
                <span>Скидка: {{ $this->discount_total }}c</span>
                <span>Итог: {{ $total_final }}c</span>
            </div>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">
                    Оформить заказь
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
