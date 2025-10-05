<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Заявки на доставку</flux:heading>
        <flux:text class="text-base" variant="subtle">Обработка и подтверждение заявок на доставку грузов клиентам.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <flux:table :paginate="$this->orders" class="">
            <flux:table.columns>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Адрес</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->orders as $item)

                <flux:table.row>
                    <flux:table.cell>{{ $item->user->code }}</flux:table.cell>
                    <flux:table.cell>{{ $item->phone}}</flux:table.cell>
                    <flux:table.cell>{{ $item->address}}</flux:table.cell>
                    <flux:table.cell>
                        @switch($item->status)
                        @case('В ожидании')
                        <flux:badge color="orange" size="sm" inset="top bottom">
                            {{ $item->status }}
                        </flux:badge>
                        @break

                        @case('Собрано')
                        <flux:badge color="lime" size="sm" inset="top bottom">
                            {{ $item->status }}
                        </flux:badge>
                        @break

                        @case('У доставщика')
                        <flux:badge color="lime" size="sm" inset="top bottom">
                            {{ $item->status }}
                        </flux:badge>
                        @break
                        @case('Доставлено')
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
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>