<div class="md:hidden">
    <div class="flex items-center justify-between rounded-2xl border border-neutral-800 bg-neutral-900/80 px-4 py-3">
        <div class="text-white text-base font-semibold tracking-wide">Shifu Cargo</div>
        <details class="relative">
            <summary
                class="list-none h-10 w-10 rounded-xl border border-neutral-700 bg-neutral-950 text-neutral-100 flex items-center justify-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 6h16" />
                    <path d="M4 12h16" />
                    <path d="M4 18h16" />
                </svg>
            </summary>
            <div
                class="absolute right-0 mt-2 w-48 rounded-2xl border border-neutral-800 bg-neutral-950 p-2 shadow-xl shadow-black/40 z-10">
                <a href="{{ route('deliver.orders') }}"
                    class="block rounded-xl px-3 py-2 text-sm font-semibold {{ $page === 'orders' ? 'bg-white text-neutral-900' : 'text-neutral-200 hover:bg-neutral-900' }}">
                    Заказы
                </a>
                <a href="{{ route('deliver.archive') }}"
                    class="block rounded-xl px-3 py-2 text-sm font-semibold {{ $page === 'archive' ? 'bg-white text-neutral-900' : 'text-neutral-200 hover:bg-neutral-900' }}">
                    Архив
                </a>
                <a href="{{ route('deliver.dashboard') }}"
                    class="block rounded-xl px-3 py-2 text-sm font-semibold {{ $page === 'dashboard' ? 'bg-white text-neutral-900' : 'text-neutral-200 hover:bg-neutral-900' }}">
                    Дашборд
                </a>
                <div class="my-2 h-px bg-neutral-800"></div>
                <button wire:click="logout" wire:confirm
                    class="w-full text-left rounded-xl px-3 py-2 text-sm font-semibold text-rose-200 hover:bg-rose-500/10">
                    Выйти
                </button>
            </div>
        </details>
    </div>
</div>

<div class="hidden md:flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
    <div>
        <flux:heading class="text-2xl text-white">Панель доставщика</flux:heading>
        <flux:text class="mt-1 text-neutral-300 max-w-2xl">
            Личные заказы, архив и статистика с фокусом на мобильный просмотр.
        </flux:text>
    </div>
    <div class="flex flex-wrap gap-3">
        <flux:button variant="danger" color="red" wire:click="logout" wire:confirm>Выйти</flux:button>
    </div>
</div>

<div class="hidden md:flex flex-wrap gap-2">
    <a href="{{ route('deliver.dashboard') }}"
        class="px-4 py-2 rounded-xl text-sm font-semibold border {{ $page === 'dashboard' ? 'bg-white text-neutral-900 border-white' : 'border-neutral-700 text-neutral-200' }}">
        Дашборд
    </a>
    <a href="{{ route('deliver.orders') }}"
        class="px-4 py-2 rounded-xl text-sm font-semibold border {{ $page === 'orders' ? 'bg-white text-neutral-900 border-white' : 'border-neutral-700 text-neutral-200' }}">
        Заказы ({{ $activeCount }})
    </a>
    <a href="{{ route('deliver.archive') }}"
        class="px-4 py-2 rounded-xl text-sm font-semibold border {{ $page === 'archive' ? 'bg-white text-neutral-900 border-white' : 'border-neutral-700 text-neutral-200' }}">
        Архив ({{ $archiveCount }})
    </a>
</div>
