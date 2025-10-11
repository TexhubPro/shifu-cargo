<div class="bg-white p-4 space-y-4">
    <div class="bg-lime-500 rounded-2xl p-2 grid grid-cols-2 lg:grid-cols-5 gap-2">
        <flux:modal.trigger name="add-expences">
            <flux:button>Добавит расходы</flux:button>
        </flux:modal.trigger>
        <flux:modal.trigger name="select-queue">
            <flux:button>Выбирать из очереди</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="bg-neutral-200 rounded-2xl p-4 space-y-3">
        <div>

            <flux:text class="text-base font-bold uppercase" variant="strong">
                Заполните форму ниже, чтобы оформить заявку.
            </flux:text>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div class="space-y-3">
                <form wire:submit="addTrack">
                    <flux:input icon="qr-code" label="Сканируйте" wire:model="newTrack"
                        placeholder="Трек-код или штрих код груза" />
                </form>
                <div class="h-96 rounded-lg bg-white overflow-y-scroll p-2">
                    @if ($tracks)
                    @foreach ($tracks as $index => $track)
                    <div class="text-lg flex justify-between items-center">
                        <span>{{ $track }}</span>
                        <button type="button" wire:click="removeTrack({{ $index }})" class="text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
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
            </div>
            <form wire:submit="order_place" class="space-y-3 col-span-2">
                <!-- Клиент -->
                <flux:autocomplete wire:model.live="client" label="Клиент" placeholder="Выберите клиента" required>
                    @foreach ($users as $user)
                    <flux:autocomplete.item>{{ $user->phone}}</flux:autocomplete.item>
                    @endforeach
                </flux:autocomplete>
                <div class="grid gap-2 grid-cols-3">
                    <!-- Номер заявки -->
                    <flux:input label="Номер заявки" placeholder="Введите номер заявки" wire:model.live="order_no" />
                    <flux:select wire:model="deliver_boy" label="Доставщик" placeholder="Выбкрите доставщика">
                        @foreach ($delivers as $deliver)
                        <flux:select.option>{{ $deliver->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <!-- Цена доставки -->
                    <flux:input label="Цена доставки (сомони)" placeholder="Введите стоимость доставки"
                        wire:model.live="delivery_price" type="number" min="0" />
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <!-- Вес груза -->
                    <flux:input label="Вес груза (кг)" placeholder="Введите общий вес груза" wire:model.live="weight"
                        required />

                    <!-- Объём груза -->
                    <flux:input label="Объём груза (м³)" placeholder="Введите примерный объём"
                        wire:model.live="volume" />
                </div>

                <!-- Скидка -->


                <div class="grid grid-cols-2 gap-2">
                    <!-- Тип оплаты -->
                    <flux:select wire:model.live="payment_type" placeholder="Выберите тип оплаты" label="Тип оплаты"
                        required>
                        <flux:select.option>Алиф Моби</flux:select.option>
                        <flux:select.option>Душанбе Сити</flux:select.option>
                        <flux:select.option>Наличными</flux:select.option>
                    </flux:select>



                    <!-- Итоговая сумма -->
                    <flux:input label="Итоговая сумма (сомони)" placeholder="Введите общую сумму"
                        wire:model.live="total_amount" type="number" min="0" required />
                </div>
                <flux:label>Скидка</flux:label>
                <div class="flex gap-2">
                    <flux:input placeholder="10" wire:model.live="discount" type="number" min="0" />

                    <flux:select wire:model="industry" placeholder="Choose industry..." wire:model.live="discountt">
                        <flux:select.option>Фиксированная</flux:select.option>
                        <flux:select.option>Процентная</flux:select.option>
                    </flux:select>
                </div>
                <div class="flex gap-5">
                    <span>Подытог: {{ $this->total_amount }}c</span>
                    <span>Цена доставка:{{ $delivery_price }}c</span>
                    <span>Скидка: {{ $this->discount_total }}c</span>
                    <span>Итог:{{ $total_final }}c</span>
                </div>
                <!-- Кнопка -->
                <flux:button type="submit" variant="primary" color="lime" class="w-full">
                    Оформить заявку
                </flux:button>
            </form>
        </div>
    </div>
    <flux:modal name="add-expences" class="md:w-96">
        <form wire:submit="addExpense" class="space-y-3">
            <div>
                <flux:heading size="lg">Добавление затрат</flux:heading>
                <flux:text class="mt-2">
                    Заполните поля, чтобы добавить новую запись о расходах, сумму и описание затрат.
                </flux:text>
            </div>


            <!-- Сумма -->
            <flux:input type="number" label="Сумма" placeholder="Введите сумму" required wire:model="amount" />

            <!-- Описание -->
            <flux:textarea label="Описание" placeholder="Введите описание затрат" wire:model="description" />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">
                    Добавить затраты
                </flux:button>
            </div>
        </form>
    </flux:modal>
    <flux:modal name="select-queue" class="md:w-96">
        <div>
            <flux:heading size="lg">Выберите клиент из очереди</flux:heading>
            <flux:text class="mt-2">
                После выбора автоматический клиент выбирается
            </flux:text>
        </div>
        <div class="space-y-3 max-h-96 overflow-y-scroll">
            @foreach ($queues as $item)
            <div class="bg-neutral-200 p-1 rounded-lg flex justify-between items-center">
                {{ $item->no }} - {{ $item->user->name }} - {{ $item->sex == "m"?"Муж":"Жен" }} <flux:button
                    variant="danger" size="sm" wire:click="select_queues({{ $item->id }})">Выбирать</flux:button>
            </div>
            @endforeach
        </div>
    </flux:modal>
</div>