<div>
    <div>
        <flux:heading class="text-xl">Список заказов</flux:heading>
        <flux:text class="text-base" variant="subtle">
            На этой странице отображаются все заказы. Здесь можно просматривать детали каждого заказа, отслеживать их
            статус
            и
            управлять списком заказов.
        </flux:text>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 space-y-3 mt-5">
        <flux:table :paginate="$this->orders" class="">
            <flux:table.columns>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Весь</flux:table.column>
                <flux:table.column>Куб</flux:table.column>
                <flux:table.column>Подытог</flux:table.column>
                <flux:table.column>Скидка</flux:table.column>
                <flux:table.column>Итог</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->orders as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->user->code ?? $item->user_id }}</flux:table.cell>
                        <flux:table.cell>{{ $item->weight }}</flux:table.cell>
                        <flux:table.cell>{{ $item->cube }}</flux:table.cell>
                        <flux:table.cell>{{ $item->subtotal }}c</flux:table.cell>
                        <flux:table.cell>{{ $item->discount }}c</flux:table.cell>
                        <flux:table.cell>{{ $item->total }}c</flux:table.cell>
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
