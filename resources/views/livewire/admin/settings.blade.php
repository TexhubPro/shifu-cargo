<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Настройки Т-БОТ</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Конфигурация Telegram-бота и автоматических уведомлений для клиентов.
        </flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-6">
        <form class="space-y-6" wire:submit.prevent="saveSettings">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <flux:input placeholder="Введите курс доллара к сомони" label="Курс 1 доллар к сомони"
                    wire:model="course_dollar" required />
                <flux:input placeholder="Введите цену за 1 куб груза" label="Цена за 1 куб груза"
                    wire:model="cube_price" required />
                <flux:input placeholder="Введите цену за 1 кг (до 10 кг)" label="Цена за 1 кг (до 10 кг)"
                    wire:model="kg_price" required />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <flux:input placeholder="Введите цену за 1 кг (10–20 кг)" label="Цена за 1 кг (10–20 кг)"
                    wire:model="kg_price_10" required />
                <flux:input placeholder="Введите цену за 1 кг (20–30 кг)" label="Цена за 1 кг (20–30 кг)"
                    wire:model="kg_price_20" required />
                <flux:input placeholder="Введите цену за 1 кг (свыше 30 кг)" label="Цена за 1 кг (свыше 30 кг)"
                    wire:model="kg_price_30" required />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <flux:textarea placeholder="Введите запрещённые товары" label="Запрещённые товары"
                    wire:model="danger_products" required />
                <div class="grid grid-cols-1 gap-4">
                    <flux:textarea placeholder="Введите адрес склада в Иву" label="Адрес склада Иву"
                        wire:model="address_ivu" required />
                    <flux:textarea placeholder="Введите адрес склада в Душанбе" label="Адрес склада Душанбе"
                        wire:model="address_dushanbe" required />
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-xs text-gray-500">
                    Проверьте цены и адреса перед сохранением — они используются в рассылках.
                </p>
                <flux:button variant="primary" color="lime" class="w-full sm:w-auto" type="submit">
                    Сохранить
                </flux:button>
            </div>
        </form>
    </div>
</div>
