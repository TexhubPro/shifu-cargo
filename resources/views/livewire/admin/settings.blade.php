<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Настройки Т-БОТ</flux:heading>
        <flux:text class="text-base" variant="subtle">Конфигурация Telegram-бота и автоматических уведомлений для
            клиентов.
        </flux:text>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 space-y-3">
        <form class="space-y-3" wire:submit.prevent="saveSettings">
            <flux:input placeholder="Введите курс доллара к сомони" label="Курс 1 доллар к сомони"
                wire:model="course_dollar" required />
            <flux:input placeholder="Введите цену за 1 кг груза" label="Цена за 1 кг груза" wire:model="kg_price"
                required />

            <flux:input placeholder="Введите цену за 1 куб груза" label="Цена за 1 куб груза" wire:model="cube_price"
                required />

            <flux:textarea placeholder="Введите запрещённые товары" label="Запрещённые товары"
                wire:model="danger_products" required />

            <flux:textarea placeholder="Введите адрес склада в Иву" label="Адрес склада Иву" wire:model="address_ivu"
                required />

            <flux:textarea placeholder="Введите адрес склада в Душанбе" label="Адрес склада Душанбе"
                wire:model="address_dushanbe" required />


            <flux:button variant="primary" color="lime" class="w-full" type="submit">
                Сохранить
            </flux:button>

        </form>
    </div>
</div>