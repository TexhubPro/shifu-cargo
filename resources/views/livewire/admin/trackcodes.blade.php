<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Трек-коды</flux:heading>
        <flux:text class="text-base" variant="subtle">Просмотр, добавление и обновление трек-кодов клиентов.</flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <div>
            <flux:heading>Проверка трек-кодов</flux:heading>
            <flux:text>
                Проверьте статус трек-кода или измените его при необходимости.
            </flux:text>
        </div>
        <form class="space-y-3" wire:submit.prevent="search_form">
            <flux:input icon="qr-code" placeholder="Сканируйте штрихкод или введите трек-код вручную" clearable
                label="Трек-код" wire:model="search" />
            <flux:button variant="primary" color="lime" class="w-full" type="submit">
                Проверить
            </flux:button>
        </form>
        <flux:table :paginate="$this->trackcodes" class="mt-5">
            <flux:table.columns>
                <flux:table.column>Трек-код</flux:table.column>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата получения</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->trackcodes as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->code }}</flux:table.cell>
                        <flux:table.cell>{{ $item->user->code ?? 'Не известно' }}</flux:table.cell>
                        <flux:table.cell>
                            @switch($item->status)
                                @case('В ожидании')
                                    <flux:badge color="orange" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Получено в Иву')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('В пункте выдачи')
                                    <flux:badge color="blue" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Получено')
                                    <flux:badge color="emerald" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @default
                                    <flux:badge color="yellow" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                            @endswitch
                        </flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                        </flux:table.cell>
                        @if (Auth::user()->role == 'admin')
                            <flux:table.cell>
                                <flux:button variant="primary" size="sm" color="red"
                                    wire:click="delete({{ $item->id }})" wire:confirm>
                                    Удалить</flux:button>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

</div>
