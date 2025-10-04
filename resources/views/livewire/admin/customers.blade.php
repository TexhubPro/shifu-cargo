<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Клиенты и коды</flux:heading>
        <flux:text class="text-base" variant="subtle">Список клиентов и их зарегистрированные коды для отслеживания
            грузов.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <div>
            <flux:heading>Информация о клиентах</flux:heading>
            <flux:text>
                Просмотрите информацию о клиентах, специальные коды и их заказы.
            </flux:text>
        </div>
        <form class="space-y-3" wire:submit.prevent="addSingleTrack">
            <flux:input icon="user" placeholder="Введите номер телефона или специальный код клиента" clearable
                label="Номер телефона или специальный код клиента" wire:model="singleTrack" required />
            <flux:button variant="primary" color="lime" class="w-full" type="submit">
                Найти
            </flux:button>
        </form>
        <flux:table class="mt-5">
            <flux:table.columns>
                <flux:table.column>Customer</flux:table.column>
                <flux:table.column>Date</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Amount</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                <flux:table.row>
                    <flux:table.cell>Lindsey Aminoff</flux:table.cell>
                    <flux:table.cell>Jul 29, 10:45 AM</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">$49.00</flux:table.cell>
                </flux:table.row>

                <flux:table.row>
                    <flux:table.cell>Hanna Lubin</flux:table.cell>
                    <flux:table.cell>Jul 28, 2:15 PM</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">$312.00</flux:table.cell>
                </flux:table.row>

                <flux:table.row>
                    <flux:table.cell>Kianna Bushevi</flux:table.cell>
                    <flux:table.cell>Jul 30, 4:05 PM</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="zinc" size="sm" inset="top bottom">Refunded</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">$132.00</flux:table.cell>
                </flux:table.row>

                <flux:table.row>
                    <flux:table.cell>Gustavo Geidt</flux:table.cell>
                    <flux:table.cell>Jul 27, 9:30 AM</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">$31.00</flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </div>
</div>