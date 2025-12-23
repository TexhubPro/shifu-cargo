@php
    $user = Auth::user();
    $avatarPath = $user->avatar
        ? asset('storage/' . $user->avatar)
        : 'https://api.dicebear.com/9.x/initials/svg?seed=' . urlencode($user->name ?? 'User');
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-2xl">Профиль администратора</flux:heading>
        <flux:text class="text-base" variant="subtle">Обновляйте личные данные и настройки доступа.</flux:text>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center gap-4">
                <flux:avatar size="lg" src="{{ $avatarPath }}" name="{{ $user->name ?? 'User' }}" />
                <div>
                    <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $user->role ?? 'user' }}</p>
                </div>
            </div>
            <div class="mt-6 space-y-3 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <span>Телефон</span>
                    <span class="font-medium text-gray-900">{{ $user->phone ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Пол</span>
                    <span class="font-medium text-gray-900">
                        {{ $user->sex ? ($user->sex == 'm' ? 'Мужской' : 'Женский') : '-' }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Код клиента</span>
                    <span class="font-medium text-gray-900">{{ $user->code ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Дата регистрации</span>
                    <span class="font-medium text-gray-900">
                        {{ $user->created_at ? $user->created_at->format('d.m.Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <form wire:submit.prevent="save" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label badge="Обязательно">Имя</flux:label>
                        <flux:input type="text" wire:model="name" required placeholder="Введите имя" />
                    </flux:field>

                    <flux:field>
                        <flux:label badge="Обязательно">Телефон</flux:label>
                        <flux:input type="phone" wire:model="phone" required placeholder="931234567" mask="999999999" />
                        <flux:error name="phone" />
                    </flux:field>
                </div>

                <flux:radio.group wire:model="sex" label="Пол" required variant="cards" badge="Обязательно">
                    <flux:radio value="m" label="Мужской" />
                    <flux:radio value="z" label="Женский" />
                </flux:radio.group>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>Новый пароль</flux:label>
                        <flux:input type="password" wire:model="password" placeholder="Введите новый пароль" />
                    </flux:field>
                    <flux:field>
                        <flux:label>Подтвердите пароль</flux:label>
                        <flux:input type="password" wire:model="password_confirmation" placeholder="Повторите пароль" />
                    </flux:field>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-xs text-gray-500">
                        Если поле пароля пустое, текущий пароль не изменится.
                    </p>
                    <flux:button variant="primary" color="lime" type="submit">
                        Сохранить изменения
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>
