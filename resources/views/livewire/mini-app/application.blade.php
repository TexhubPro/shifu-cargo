<div>
    <div class="flex gap-2 justify-between items-center">
        <div>
            <flux:heading>Оформить доставку</flux:heading>
            <flux:text>Заполните данные и мы организуем доставку вашего груза</flux:text>
        </div>
        <flux:modal.trigger name="edit-profile">
            <flux:button variant="primary" size="sm" color="lime">Заказать</flux:button>
        </flux:modal.trigger>
    </div>
    @if($applications)
    <flux:table>
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Номер телефон</flux:table.column>
            <flux:table.column>Адрес</flux:table.column>
            <flux:table.column>Статус</flux:table.column>
            <flux:table.column>Дата</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            <flux:table.row>
                <flux:table.cell>001</flux:table.cell>
                <flux:table.cell>005335051</flux:table.cell>
                <flux:table.cell variant="strong">103мкр</flux:table.cell>
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
    <flux:modal name="edit-profile" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Новый заказ на доставку</flux:heading>
                <flux:text class="mt-2">Заполните все необходимые поля, чтобы оформить доставку вашего груза.
                </flux:text>
            </div>
            <form class="space-y-4">
                <flux:input label="Номер телефон" placeholder="Введите свой номер телефон" required />
                <flux:input label="Адрес" placeholder="Введите свой адрес" required />
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary" color="lime">Заказать</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>