<div>
    <div>
        <flux:heading>Свяжитесь с нами</flux:heading>
        <flux:text>Мы готовы ответить на ваши вопросы и помочь с доставкой</flux:text>
    </div>
    <div class="bg-neutral-800 border border-neutral-700 rounded-xl p-1 pt-4 mt-4  relative">
        <ul wire:poll.5s class="space-y-3 flex flex-col-reverse px-1 h-[calc(100vh-310px)] overflow-y-scroll [&::-webkit-scrollbar]:w-1
        [&::-webkit-scrollbar-track]:bg-gray-100
        [&::-webkit-scrollbar-thumb]:bg-gray-300
        dark:[&::-webkit-scrollbar-track]:bg-neutral-700
        dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            @if($messages)
            @foreach ($messages as $item)
            @if($item->is_admin)
            <li class="max-w-60 flex gap-x-2 sm:gap-x-4 me-11">
                <div>
                    <div class="bg-white text-sm text-white rounded-2xl px-4 py-2 space-y-3 dark:bg-neutral-900">
                        {{ $item->message }}
                    </div>
                    <span class="mt-1.5 flex items-center gap-x-1 text-xs text-gray-500 dark:text-neutral-500">
                        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 7 17l-5-5"></path>
                            <path d="m22 10-7.5 7.5L13 16"></path>
                        </svg>
                        {{ $item->created_at }}
                    </span>
                </div>
            </li>
            @else
            <li class="flex ms-auto gap-x-2 sm:gap-x-4">
                <div class="grow text-end space-y-3">
                    <div class="inline-flex flex-col justify-end">
                        <div class="text-sm text-white inline-block bg-lime-800 rounded-2xl py-2 px-4 shadow-2xs">
                            {{ $item->message }}
                        </div>

                        <span
                            class="mt-1.5 ms-auto flex items-center gap-x-1 text-xs text-gray-500 dark:text-neutral-500">
                            <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 7 17l-5-5"></path>
                                <path d="m22 10-7.5 7.5L13 16"></path>
                            </svg>
                            {{ $item->created_at }}
                        </span>
                    </div>
                </div>
            </li>
            @endif
            @endforeach
            @else
            @include('partials.empty-page')
            @endif
        </ul>
        <form wire:submit="add_message"
            class="relative h-10 bg-neutral-900 border border-neutral-600 rounded-lg mt-2 overflow-hidden">
            <input wire:model="message" type="text" class="h-full w-full bg-transparent border-0 outline-0 text-white"
                placeholder="Выедите сообщения здесь" required>
            <button type="submit"
                class="absolute top-0 right-0 bg-lime-500 h-full px-3 text-white font-semibold">Отправить</button>
        </form>
    </div>
</div>