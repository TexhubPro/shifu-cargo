<div>
    <div class="flex gap-2 justify-between items-center">
        <div>
            <flux:heading>Все ваши трек-коды</flux:heading>
            <flux:text class="text-xs">Отслеживайте статус всех ваших посылок</flux:text>
        </div>
        <flux:button variant="primary" size="sm" color="lime" href="{{ route('add-order') }}">Добавить</flux:button>
    </div>
    @if ($orders->count() > 0)
        <flux:table :paginate="$orders">
            <flux:table.columns>
                <flux:table.column>Трек-код</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($orders as $order)
                    <flux:table.row>
                        <flux:table.cell>{{ $order->code }}</flux:table.cell>
                        <flux:table.cell>
                            @switch($order->status)
                                @case('В ожидании')
                                    <flux:badge color="orange" size="sm" inset="top bottom">
                                        {{ $order->status }}
                                    </flux:badge>
                                @break

                                @case('Получено в Иву')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $order->status }}
                                    </flux:badge>
                                @break

                                @case('В пункте выдачи')
                                    <flux:badge color="blue" size="sm" inset="top bottom">
                                        {{ $order->status }}
                                    </flux:badge>
                                @break

                                @case('Получено')
                                    <flux:badge color="emerald" size="sm" inset="top bottom">
                                        {{ $order->status }}
                                    </flux:badge>
                                @break

                                @default
                                    <flux:badge color="yellow" size="sm" inset="top bottom">
                                        {{ $order->status }}
                                    </flux:badge>
                            @endswitch
                        </flux:table.cell>
                        <flux:table.cell>{{ $order->created_at->format('H:i | d.m.Y') }}</flux:table.cell>
                        @if ($order->status == 'В ожидании')
                            <flux:table.cell>
                                <flux:button variant="primary" size="sm" color="red"
                                    wire:click="delete({{ $order->id }})" wire:confirm>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </flux:button>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach

            </flux:table.rows>
        </flux:table>
    @else
        @include('partials.empty-page')
    @endif
</div>
