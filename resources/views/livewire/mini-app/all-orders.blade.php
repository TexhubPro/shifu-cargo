<div>
    <div class="flex gap-2 justify-between items-center">
        <div>
            <flux:heading>Все ваши трек-коды</flux:heading>
            <flux:text class="text-xs">Отслеживайте статус всех ваших посылок</flux:text>
        </div>
        <flux:button variant="primary" size="sm" color="lime" href="{{ route('add-order') }}">Добавить</flux:button>
    </div>
    @if($orders)
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Трек-код</flux:table.column>
            <flux:table.column>Статус</flux:table.column>
            <flux:table.column>Дата</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            <flux:table.row>
                <flux:table.cell>001</flux:table.cell>
                <flux:table.cell>
                    <flux:badge color="green" size="sm" inset="top bottom">В ожидании</flux:badge>
                </flux:table.cell>
                <flux:table.cell>02.10.2025</flux:table.cell>
            </flux:table.row>

        </flux:table.rows>
    </flux:table>
    @else
    @include('partials.empty-page')
    @endif
</div>