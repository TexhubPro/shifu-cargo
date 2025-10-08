<div class="bg-white p-4 space-y-4">
    <div class="bg-lime-500 rounded-2xl p-2 grid grid-cols-2 lg:grid-cols-5 gap-2">
        <flux:button>Добавит расходы</flux:button>
        <flux:button>Оформить доставка</flux:button>
        <flux:button>Выбирать из очереди</flux:button>
    </div>
    <div class="bg-neutral-950 rounded-2xl p-4 space-y-3">
        <div>
            <flux:text class="text-base" variant="subtle">
                Заполните форму ниже, чтобы оформить заявку.
            </flux:text>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div class="space-y-3">
                <flux:input icon="qr-code" label="Сканируйте" placeholder="Трек-код или штрих код груза" />
                <div class="h-full">

                </div>
            </div>
            <form class="space-y-3 col-span-2">
                <!-- Клиент -->
                <flux:autocomplete wire:model="client" label="Клиент" placeholder="Выберите клиента">
                    <flux:autocomplete.item>Alabama</flux:autocomplete.item>
                    <flux:autocomplete.item>Arkansas</flux:autocomplete.item>
                    <flux:autocomplete.item>California</flux:autocomplete.item>
                </flux:autocomplete>
                <div class="grid gap-2 grid-cols-2">
                    <!-- Номер заявки -->
                    <flux:input label="Номер заявки" placeholder="Введите номер заявки" wire:model="order_no"
                        required />

                    <!-- Цена доставки -->
                    <flux:input label="Цена доставки (сомони)" placeholder="Введите стоимость доставки"
                        wire:model="delivery_price" type="number" min="0" required />
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <!-- Вес груза -->
                    <flux:input label="Вес груза (кг)" placeholder="Введите общий вес груза" wire:model="weight"
                        required />

                    <!-- Объём груза -->
                    <flux:input label="Объём груза (м³)" placeholder="Введите примерный объём" wire:model="volume" />
                </div>

                <!-- Скидка -->
                <flux:label>Скидка</flux:label>
                <div class="flex gap-2">
                    <flux:input placeholder="10" wire:model="discount" type="number" min="0" />
                    <flux:radio.group wire:model="discount_type" variant="buttons" class="w-full *:flex-1">
                        <flux:radio icon="calculator" value="fixed">Фиксированная</flux:radio>
                        <flux:radio icon="percent-badge" value="percent">Процентная</flux:radio>
                    </flux:radio.group>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <!-- Тип оплаты -->
                    <flux:select wire:model="payment_type" placeholder="Выберите тип оплаты" label="Тип оплаты"
                        required>
                        <flux:select.option>Алиф Моби</flux:select.option>
                        <flux:select.option>Душанбе Сити</flux:select.option>
                        <flux:select.option>Наличными</flux:select.option>
                    </flux:select>



                    <!-- Итоговая сумма -->
                    <flux:input label="Итоговая сумма (сомони)" placeholder="Введите общую сумму"
                        wire:model="total_amount" type="number" min="0" required />
                </div>

                <!-- Кнопка -->
                <flux:button variant="primary" color="lime" class="w-full">
                    Оформить заявку
                </flux:button>
            </form>
        </div>
    </div>
</div>