<div>
    <flux:heading>Уведомления</flux:heading>
    <flux:text>
        Здесь отображаются все уведомления о ваших заказах. Следите за статусом доставки и будьте всегда в курсе
        обновлений.
    </flux:text>
    @if($notifications->isEmpty())
    @include('partials.empty-page')
    @else
    <div class="space-y-2 mt-5">
        @foreach($notifications as $notification)
        <div
            class="bg-neutral-800 border border-neutral-700 rounded-xl p-2 text-yellow-500 font-semibold text-base/6 flex  gap-2 items-start justify-start relative">
            <div class="absolute top-1.5 left-1.5 bg-yellow-500 text-white p-1 rounded-lg">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-bell-ringing-2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M19.364 4.636a2 2 0 0 1 0 2.828a7 7 0 0 1 -1.414 7.072l-2.122 2.12a4 4 0 0 0 -.707 3.536l-11.313 -11.312a4 4 0 0 0 3.535 -.707l2.121 -2.123a7 7 0 0 1 7.072 -1.414a2 2 0 0 1 2.828 0z" />
                    <path d="M7.343 12.414l-.707 .707a3 3 0 0 0 4.243 4.243l.707 -.707" />
                </svg>
            </div>
            <span class="ml-8">{{ $notification->content }}</span>
        </div>
        @endforeach
    </div>
    @endif
</div>