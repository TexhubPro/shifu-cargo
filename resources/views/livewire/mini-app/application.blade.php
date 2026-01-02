<div>
    <div class="flex gap-2 justify-between items-center">
        <div>
            <flux:heading>Оформить доставку</flux:heading>
            <flux:text>Заполните данные и мы организуем доставку вашего груза</flux:text>
        </div>
        <flux:modal.trigger name="add-order">
            <flux:button variant="primary" size="sm" color="lime">Заказать</flux:button>
        </flux:modal.trigger>
    </div>
    @if ($applications->count() > 0)
        <flux:table :paginate="$applications">
            <flux:table.columns>
                <flux:table.column>#</flux:table.column>
                <flux:table.column>Номер телефон</flux:table.column>
                <flux:table.column>Адрес</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($applications as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->id }}</flux:table.cell>
                        <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->address }}</flux:table.cell>
                        <flux:table.cell>
                            @switch($item->status)
                                @case('В ожидании')
                                    <flux:badge color="yellow" size="sm" inset="top bottom">{{ $item->status }}</flux:badge>
                                @break

                                @case('Подтверждено')
                                    <flux:badge color="green" size="sm" inset="top bottom">{{ $item->status }}</flux:badge>
                                @break

                                @case('Доставляется')
                                    <flux:badge color="blue" size="sm" inset="top bottom">{{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Выполнено')
                                    <flux:badge color="gray" size="sm" inset="top bottom">{{ $item->status }}
                                    </flux:badge>
                                @break

                                @default
                                    <flux:badge color="red" size="sm" inset="top bottom">{{ $item->status }}
                                    </flux:badge>
                            @endswitch
                        </flux:table.cell>
                        <flux:table.cell>{{ $item->created_at->format('H:i | d.m.Y') }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @else
        @include('partials.empty-page')
    @endif
    <flux:modal name="add-order" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Новый заказ на доставку</flux:heading>
                <flux:text class="mt-2">Заполните все необходимые поля, чтобы оформить доставку вашего груза.
                </flux:text>
            </div>
            <form wire:submit="save" class="space-y-4">
                <div x-data="{
                    phone: @entangle('phone').live,
                    updatePhone(value) {
                        // Разрешаем только цифры
                        value = value.replace(/[^0-9]/g, '');
                
                        // Ограничиваем до 9 символов
                        if (value.length > 9) {
                            value = value.slice(0, 9);
                        }
                
                        this.phone = value;
                    }
                }">
                    <flux:input label="Номер телефон пример : (931234567)" type="text"
                        placeholder="Введите свой номер телефон" x-model="phone"
                        x-on:input="updatePhone($event.target.value)" maxlength="9" inputmode="numeric" required />

                    <!-- Ошибка Livewire -->
                    @error('phone')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div x-data="{
                    address: @entangle('address').live,
                    error: '',
                    updateAddress(value) {
                        // Разрешаем: буквы, цифры, пробел, запятая, точка, тире
                        value = value.replace(/[^A-Za-zА-Яа-я0-9.,\-\s]/g, '');
                
                        // Устанавливаем обратно
                        this.address = value;
                
                        // Минимум 5 символов
                        if (this.address.length < 5) {
                            this.error = 'Адрес должен содержать минимум 5 символов';
                        } else {
                            this.error = '';
                        }
                    }
                }">
                    <flux:input label="Адрес (пример: 103мкр, Тайга)" placeholder="Введите свой адрес" type="text"
                        x-model="address" x-on:input="updateAddress($event.target.value)" required />

                    <!-- Ошибка Alpine -->
                    <div x-show="error" class="text-red-600 text-sm mt-1" x-text="error"></div>

                    <!-- Ошибка Livewire -->
                    @error('address')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary" color="lime">Заказать</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
    {{-- <div
        class="rounded-2xl border border-amber-200/50 bg-gradient-to-br from-amber-50 via-white to-amber-100/40 p-5 shadow-sm">
        <div class="flex items-start gap-3">
            <div
                class="flex size-10 items-center justify-center rounded-full bg-amber-100 text-amber-700 ring-1 ring-amber-200">
                ⚠️
            </div>
            <div class="space-y-2">
                <div class="text-base font-semibold text-amber-900">Заказать доставку временно недоступно</div>
                <div class="text-sm leading-6 text-amber-900/80">
                    Сейчас заказ доставки временно недоступен. В ближайшее время сервис снова заработает, мы обязательно
                    сообщим об этом.
                </div>
                <a class="inline-flex items-center gap-2 text-sm font-semibold text-amber-700 hover:text-amber-800"
                    href="https://www.instagram.com/cargo_shifu" target="_blank" rel="noopener noreferrer">
                    Написать в Instagram
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </div> --}}
</div>
