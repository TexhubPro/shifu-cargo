<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-col gap-2">
            <flux:heading class="text-xl">Сотрудники</flux:heading>
            <flux:text class="text-sm" variant="subtle">
                Управляйте учетными записями сотрудников и их ролями в системе.
            </flux:text>
        </div>
        <flux:modal.trigger name="edit-profile">
            <flux:button variant="primary" color="lime">Добавить</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Список сотрудников</flux:heading>
            <flux:text>Включайте/отключайте доступ и редактируйте данные.</flux:text>
        </div>
        <flux:table :paginate="$this->users">
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
                                @if ($item->status == true)
                                    <flux:switch wire:click="notifications({{ $item->id }})" checked />
                                @else
                                    <flux:switch wire:click="notifications({{ $item->id }})" />
                                @endif
                            </flux:field>
                        </flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                        </flux:table.cell>
                        <flux:table.cell class="grid grid-cols-2 gap-2">
                            <flux:modal.trigger name="edit-employee" wire:click="openEdit({{ $item->id }})">
                                <flux:button variant="outline" size="sm">Изменить</flux:button>
                            </flux:modal.trigger>
                            <flux:button variant="primary" size="sm" color="red"
                                wire:click="delete({{ $item->id }})" wire:confirm>
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

    <flux:modal name="edit-employee" class="md:w-96">
        <form wire:submit="updateEmployee" class="space-y-6">
            <div>
                <flux:heading size="lg">Редактирование сотрудника</flux:heading>
                <flux:text class="mt-2">Обновите данные сотрудника. Пароль можно оставить пустым.</flux:text>
            </div>

            <flux:input label="Имя сотрудника" placeholder="Введите имя" required wire:model.defer="editName" />
            <flux:input label="Телефон" placeholder="Введите номер телефона" required wire:model.defer="editPhone" />
            <flux:input label="Новый пароль" type="password" placeholder="Оставьте пустым, если не нужно"
                wire:model.defer="editPassword" />

            <flux:select label="Должность (роль)" placeholder="Выберите должность..." required wire:model="editRole">
                <flux:select.option value="admin">Администратор</flux:select.option>
                <flux:select.option value="deliver">Курьер</flux:select.option>
                <flux:select.option value="manager">Менеджер</flux:select.option>
                <flux:select.option value="cashier">Кассир</flux:select.option>
                <flux:select.option value="applicant">Заявщик</flux:select.option>
            </flux:select>
            <flux:input label="Telegram Chat Id" placeholder="Введите Telegram Chat Id" wire:model.defer="editChatId" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="updateEmployee">
                    Сохранить изменения
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
