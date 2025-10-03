<div>
    <div class="flex gap-2 justify-between items-center">
        <div>
            <flux:heading>Все ваши трек-коды</flux:heading>
            <flux:text class="text-xs">Отслеживайте статус всех ваших посылок</flux:text>
        </div>
        <flux:button variant="primary" size="sm" color="lime" href="{{ route('add-order') }}">Добавить</flux:button>
    </div>
    @if($orders)
    <flux:table :paginate="$orders">
        <flux:table.columns>
            <flux:table.column>Трек-код</flux:table.column>
            <flux:table.column>Статус</flux:table.column>
            <flux:table.column>Дата</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($orders as $order )
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
            </flux:table.row>
            @endforeach

        </flux:table.rows>
    </flux:table>
    @else
    @include('partials.empty-page')
    @endif
</div>