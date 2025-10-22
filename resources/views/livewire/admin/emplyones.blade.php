<div>
    <div class="mb-5 flex justify-between items-center gap-5">
        <div>
            <flux:heading class="text-xl">Сотрудники</flux:heading>
            <flux:text class="text-base" variant="subtle">Управление учетными записями сотрудников и их ролями в
                системе.
            </flux:text>
        </div>
        <flux:modal.trigger name="edit-profile">
            <flux:button variant="primary" color="lime">Добавить</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <flux:table :paginate="$this->users" class="mt-5">
            <flux:table.columns>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Рол</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
                <flux:table.column>Действия</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->users as $item)

                <flux:table.row>
                    <flux:table.cell>{{ $item->name }}</flux:table.cell>
                    <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                    <flux:table.cell>{{ $item->role }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:field variant="inline">
                            @if($item->status == true)
                            <flux:switch wire:click="notifications({{$item->id  }})" checked />
                            @else
                            <flux:switch wire:click="notifications({{$item->id  }})" />
                            @endif
                        </flux:field>
                    </flux:table.cell>
                    <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button variant="primary" size="sm" color="red" wire:click="delete({{ $item->id }})"
                            wire:confirm>
                            Удалить</flux:button>
                    </flux:table.cell>
                </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>


    <flux:modal name="edit-profile" class="md:w-96">
        <form wire:submit="saveEmployee" class="space-y-6">
            <div>
                <flux:heading size="lg">Добавление сотрудника</flux:heading>
                <flux:text class="mt-2">Заполните данные нового сотрудника.</flux:text>
            </div>

            <flux:input label="Имя сотрудника" placeholder="Введите имя" required wire:model.defer="name" />

            <flux:input label="Телефон" placeholder="Введите номер телефона" required wire:model.defer="phone" />

            <flux:input label="Пароль" type="password" placeholder="Введите пароль" required
                wire:model.defer="password" />

            <flux:select label="Должность (роль)" placeholder="Выберите должность..." required wire:model="role">
                <flux:select.option value="admin">Администратор</flux:select.option>
                <flux:select.option value="deliver">Курьер</flux:select.option>
                <flux:select.option value="manager">Менеджер</flux:select.option>
                <flux:select.option value="cashier">Кассир</flux:select.option>
                <flux:select.option value="applicant">Заявщик</flux:select.option>
            </flux:select>
            <flux:input label="Telegram Chat Id" placeholder="Введите Telegram Chat Id" wire:model.defer="chat_id" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="saveEmployee">
                    Добавить сотрудника
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>