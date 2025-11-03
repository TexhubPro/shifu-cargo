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
        <form class="space-y-3" wire:submit.prevent="check_user">
            <flux:input icon="user" placeholder="Введите номер телефона или специальный код клиента" clearable
                label="Номер телефона или специальный код клиента" wire:model="search" required />
            <flux:button variant="primary" color="lime" class="w-full" type="submit">
                Найти
            </flux:button>
        </form>
        <flux:table :paginate="$this->customers" class="mt-5">
            <flux:table.columns>
                <flux:table.column>Код</flux:table.column>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Пол</flux:table.column>
                <flux:table.column>Все заказы</flux:table.column>
                <flux:table.column>Сумма заказов</flux:table.column>
                <flux:table.column>Дата присоеденения</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->customers as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->code }}</flux:table.cell>
                        <flux:table.cell>{{ $item->name }}</flux:table.cell>
                        <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                        <flux:table.cell>{{ $item->sex == 'z' ? 'Женский' : 'Мужской' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->trackcodes->count() }}</flux:table.cell>
                        <flux:table.cell>{{ $item->orders->sum('total') }}c</flux:table.cell>
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
