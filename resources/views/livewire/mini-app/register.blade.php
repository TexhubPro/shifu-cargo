<div class="max-w-sm mx-auto p-4 space-y-4">
    <div class="py-10">
        <form wire:submit="save" class="bg-neutral-800 border border-neutral-700 rounded-xl p-4">
            <flux:heading class="text-xl">Регистрация аккаунта</flux:heading>
            <flux:text class="mt-2">Создайте личный кабинет, чтобы отслеживать заказы и пользоваться всеми возможностями
                сервиса.</flux:text>
            <div class="space-y-4 mt-5">
                <flux:field>
                    <flux:label badge="Обязательно">Имя</flux:label>
                    <flux:input type="text" wire:model="name" required placeholder="Введите свой имя" />
                </flux:field>

                <flux:field>
                    <flux:label badge="Обязательно">Номер телефон</flux:label>

                    <flux:input type="phone" wire:model="phone" required placeholder="931234567" mask="999999999" />

                    <flux:error name="phone" />
                </flux:field>
                <flux:radio.group wire:model="sex" label="Выберите пол" required variant="cards" badge="Обязательно">
                    <flux:radio value="m" label="Мужской" checked />
                    <flux:radio value="z" label="Женский" />
                </flux:radio.group>
                <flux:button variant="primary" color="lime" class="w-full" type="submit">Регистрация</flux:button>
            </div>
        </form>
        @if($message)
        <div class="mt-2 bg-gray-100 border border-gray-200 text-sm text-gray-800 rounded-lg p-4 dark:bg-white/10 dark:border-white/20 dark:text-white"
            role="alert" tabindex="-1" aria-labelledby="hs-soft-color-dark-label">
            {{ $message }}
        </div>
        @endif

    </div>
</div>