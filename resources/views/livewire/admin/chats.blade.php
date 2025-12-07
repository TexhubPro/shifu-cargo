<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Чат с клиентами</flux:heading>
        <flux:text class="text-base" variant="subtle">Реальное время общения с клиентами через встроенный Telegram-чат.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3 mt-5">
        <div class="grid lg:grid-cols-3 gap-2 h-[calc(100vh-200px)]">
            <div
                class="h-full bg-neutral-100 rounded-lg p-2 space-y-2 {{ $active_chat ? ' hidden' : '' }} lg:block
                overflow-y-scroll">
                @foreach ($chats as $chat)
                    <button type="button" wire:click="open_chat({{ $chat->id }})"
                        class="bg-white p-1 rounded-md flex gap-2 w-full text-start">
                        <flux:avatar name="Caleb Porzio" />
                        <div>
                            <flux:heading class="flex items-center gap-2">{{ $chat->user->name ?? 'Не известьно' }}

                                @if ($chat->unread_messages_count > 0)
                                    <span class="rounded-full p-1 text-xs bg-red-500 text-white">
                                        {{ $chat->unread_messages_count }}
                                    </span>
                                @endif
                            </flux:heading>
                            <flux:text class="text-xs ">{{ $chat->updated_at }}
                            </flux:text>
                        </div>
                    </button>
                @endforeach
            </div>
            <div
                class="h-full {{ $active_chat ? ' ' : ' hidden lg:block' }} bg-neutral-100 rounded-lg col-span-2 p-2
                space-y-3 overflow-hidden relative">
                @if ($active_chat)
                    <div class="w-full p-2 bg-lime-500 rounded-md flex gap-2 items-center">
                        <flux:button type="button" wire:click="back" size="sm" icon="arrow-left"></flux:button>
                        <flux:heading>{{ $active_chat->user->name }} - {{ $active_chat->user->code }} -
                            {{ $active_chat->user->phone }}</flux:heading>
                        <flux:spacer />
                        <flux:button size="sm" variant="ghost" color="white"
                            wire:click="markChatAsRead({{ $active_chat->id }})">
                            Пометить прочитанным
                        </flux:button>
                    </div>
                    <div class="h-full space-y-2 flex flex-col-reverse pb-28 overflow-hidden overflow-y-scroll">
                        @foreach ($messages as $message)
                            @if ($message->is_admin == true)
                                <div class="w-full grid justify-end">
                                    <div
                                        class="bg-lime-600 rounded-l-2xl rounded-br-2xl max-w-72 p-2 w-fit min-w-32 text-white">
                                        {{ $message->message }}
                                    </div>
                                    <span
                                        class="text-neutral-500 text-xs mt-1">{{ $message->created_at->format('H:i | d.m.Y') }}</span>
                                </div>
                            @else
                                <div class="w-full grid justify-start">
                                    <div
                                        class="bg-neutral-400 rounded-r-2xl rounded-bl-2xl max-w-72 p-2 w-fit min-w-32 text-white">
                                        {{ $message->message }}
                                    </div>
                                    <span
                                        class="text-neutral-500 text-xs text-end mt-1">{{ $message->created_at->format('H:i |
                                                                                                                                                                                                                                    d.m.Y') }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="h-12 bg-lime-500 w-full absolute bottom-0 left-0 overflow-hidden">
                        <form wire:submit="add_message" class="h-full w-full relative">
                            <input type="text" required wire:model="message"
                                class="h-full w-full bg-transparent border-0 text-white placeholder:text-white/70"
                                placeholder="Введите сообщения">
                            <button type="submit"
                                class="bg-lime-950 font-semibold absolute top-0 right-0 h-full px-5 text-white">Отправить</button>
                        </form>
                    </div>
                @else
                    @include('partials.empty-page')
                @endif
            </div>

        </div>
    </div>
</div>
