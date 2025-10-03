<div>
    <div class="flex gap-2 justify-between items-center">
        <div>
            <flux:heading>Оформить доставку</flux:heading>
            <flux:text>Заполните данные и мы организуем доставку вашего груза</flux:text>
        </div>
        <flux:modal.trigger name="add-order">
            <flux:button variant="primary" size="sm" color="lime">Заказать</flux:button>
        </flux:modal.trigger>
    </div>
    @if($applications->count() > 0)
    <flux:table :paginate="$applications">
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Номер телефон</flux:table.column>
            <flux:table.column>Адрес</flux:table.column>
            <flux:table.column>Статус</flux:table.column>
            <flux:table.column>Дата</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($applications as $item)
            <flux:table.row>
                <flux:table.cell>{{ $item->id }}</flux:table.cell>
                <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                <flux:table.cell variant="strong">{{ $item->address }}</flux:table.cell>
                <flux:table.cell>
                    @switch($item->status)
                    @case('В ожидании')
                    <flux:badge color="yellow" size="sm" inset="top bottom">{{ $item->status }}</flux:badge>
                    @break

                    @case('Подтверждено')
                    <flux:badge color="green" size="sm" inset="top bottom">{{ $item->status }}</flux:badge>
                    @break

                    @case('Доставляется')
                    <flux:badge color="blue" size="sm" inset="top bottom">{{ $item->status }}</flux:badge>
                    @break

                    @case('Выполнено')
                    <flux:badge color="gray" size="sm" inset="top bottom">{{ $item->status }}</flux:badge>
                    @break

                    @default
                    <flux:badge color="red" size="sm" inset="top bottom">{{ $item->status }}</flux:badge>
                    @endswitch
                </flux:table.cell>
                <flux:table.cell>{{ $item->created_at->format('H:i | d.m.Y') }}</flux:table.cell>
            </flux:table.row>

            @endforeach
        </flux:table.rows>
    </flux:table>
    @else
    @include('partials.empty-page')
    @endif
    <flux:modal name="add-order" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Новый заказ на доставку</flux:heading>
                <flux:text class="mt-2">Заполните все необходимые поля, чтобы оформить доставку вашего груза.
                </flux:text>
            </div>
            <form wire:submit="save" class="space-y-4">
                <flux:input wire:model="phone" label="Номер телефон" placeholder="Введите свой номер телефон"
                    required />
                <flux:input wire:model="address" label="Адрес" placeholder="Введите свой адрес" required />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary" color="lime">Заказать</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>