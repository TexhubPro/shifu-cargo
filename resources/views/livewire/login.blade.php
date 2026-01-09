<div class="max-w-sm mx-auto p-4 space-y-4">
    <div
        class="w-full bg-neutral-800 rounded-xl border border-neutral-700 mt-32 p-4 flex justify-center flex-col items-center">
        <img src="{{ asset('logo/white_logo.svg') }}" class="h-12 mb-5" alt="Логотип">

        <flux:heading class="text-xl">Вход в аккаунт</flux:heading>
        <flux:text class="mt-2 text-center max-w-60">
            Введите номер телефона и пароль, чтобы войти в свой аккаунт.
        </flux:text>

        <form wire:submit="login" class="w-full mt-5 space-y-3">
            <div class="space-y-2">
                <flux:label class="text-white">Номер телефона</flux:label>
                <flux:input type="number" required wire:model="phone" placeholder="Введите номер телефона" />
            </div>
            <div class="space-y-2">
                <flux:label class="text-white">Пароль</flux:label>
                <flux:input type="password" required wire:model="password" placeholder="Введите пароль" />
            </div>
            <flux:field variant="inline">
                <flux:checkbox wire:model="remember" />
                <flux:label class="text-white">Запомнить меня</flux:label>
            </flux:field>
            <flux:button type="submit" variant="primary" color="lime" class="w-full mt-3">Войти</flux:button>
        </form>
    </div>
</div>
