<div>
    <flux:heading>Настройки аккаунта</flux:heading>
    <flux:text>Управляйте своими личными данными, уведомлениями и предпочтениями</flux:text>
    <form wire:submit.prevent="save" class="bg-neutral-800 border border-neutral-700 rounded-xl p-2 mt-5">
        <flux:heading class="text-xl">Редактирование профиля</flux:heading>
        <flux:text class="mt-2">
            Обновите ваши данные, чтобы они были актуальными для заказов и уведомлений.
        </flux:text>
        <div class="space-y-4 mt-5">
            <flux:field>
                <flux:label badge="Обязательно">Имя</flux:label>
                <flux:input type="text" wire:model="name" required placeholder="Введите ваше имя" />
            </flux:field>

            <flux:field>
                <flux:label badge="Обязательно">Номер телефон</flux:label>
                <flux:input type="phone" wire:model="phone" required placeholder="931234567" mask="999999999" />
                <flux:error name="phone" />
            </flux:field>

            <flux:radio.group wire:model="sex" label="Выберите пол" required variant="cards" badge="Обязательно">
                <flux:radio value="m" label="Мужской" />
                <flux:radio value="z" label="Женский" />
            </flux:radio.group>

            <flux:button variant="primary" color="lime" class="w-full" type="submit">Сохранить изменения</flux:button>
        </div>
    </form>
</div>