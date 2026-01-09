<div class="space-y-8">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-2xl">Дашборд заявщика</flux:heading>
        <flux:text class="text-sm text-gray-600">
            Сводка по заявкам, чатам и активности за последние 7 дней.
        </flux:text>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Заявки в ожидании</p>
            <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $pendingCount }}</p>
            <p class="text-gray-500 text-sm mt-1">Нужно обработать</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Оформлено сегодня</p>
            <p class="text-3xl font-semibold text-emerald-600 mt-1">{{ $ordersToday }}</p>
            <p class="text-gray-500 text-sm mt-1">Заказов за текущий день</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Чаты с клиентами</p>
            <p class="text-3xl font-semibold text-gray-900 mt-1">{{ $chatsCount }}</p>
            <p class="text-gray-500 text-sm mt-1">Всего диалогов</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Непрочитанные</p>
            <p class="text-3xl font-semibold text-rose-600 mt-1">{{ $unreadMessages }}</p>
            <p class="text-gray-500 text-sm mt-1">Сообщений от клиентов</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Заявки за 7 дней</flux:heading>
                <span class="text-xs text-gray-500">Всего: {{ $applicationsByDay->sum('value') }}</span>
            </div>
            <div class="flex items-end gap-2 h-44">
                @foreach ($applicationsByDay as $item)
                    @php
                        $height = (int) round(($item['value'] / $maxApplications) * 100);
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-blue-100 rounded-xl overflow-hidden">
                            <div class="bg-blue-600 rounded-xl transition-all"
                                style="height: {{ max(8, $height) }}px"></div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $item['label'] }}</span>
                        <span class="text-xs font-semibold text-gray-700">{{ $item['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Свежие чаты</flux:heading>
                <a href="{{ route('applicant.chats') }}" class="text-xs text-blue-600 hover:text-blue-700">
                    Открыть
                </a>
            </div>
            <div class="space-y-3">
                @forelse ($recentChats as $chat)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 p-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $chat->user->name ?? 'Клиент' }}
                            </p>
                            <p class="text-xs text-gray-500">Чат #{{ $chat->id }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Непрочитано</p>
                            <p class="text-lg font-semibold text-rose-600">{{ $chat->unread_messages_count }}</p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 p-4 text-sm text-gray-500">
                        Новых чатов пока нет.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <flux:heading size="lg">Последние заявки</flux:heading>
            <a href="{{ route('applicant') }}" class="text-xs text-blue-600 hover:text-blue-700">
                Открыть
            </a>
        </div>
        <div class="space-y-3">
            @forelse ($recentApplications as $application)
                <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 p-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $application->user->name ?? 'Клиент' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ $application->phone ?? 'Телефон не указан' }} ·
                            {{ $application->address ?? 'Адрес не указан' }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Статус</p>
                        <p class="text-sm font-semibold text-gray-700">{{ $application->status }}</p>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-dashed border-gray-200 p-4 text-sm text-gray-500">
                    Заявок пока нет.
                </div>
            @endforelse
        </div>
    </div>
</div>
