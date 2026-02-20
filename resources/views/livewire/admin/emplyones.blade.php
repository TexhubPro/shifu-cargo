<div class="space-y-6">
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Сотрудники</flux:heading>

            <div class="flex items-center gap-2">
                <flux:modal.trigger name="edit-profile">
                    <flux:button variant="primary" color="lime">Добавить</flux:button>
                </flux:modal.trigger>

                <flux:modal.trigger name="employees-filters">
                    <flux:button variant="primary" color="lime" square size="base" class="shrink-0 !text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-adjustments">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M6 3a1 1 0 0 1 .993 .883l.007 .117v3.171a3.001 3.001 0 0 1 0 5.658v7.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-7.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-3.17a1 1 0 0 1 1 -1z" />
                            <path
                                d="M12 3a1 1 0 0 1 .993 .883l.007 .117v9.171a3.001 3.001 0 0 1 0 5.658v1.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-1.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-9.17a1 1 0 0 1 1 -1z" />
                            <path
                                d="M18 3a1 1 0 0 1 .993 .883l.007 .117v.171a3.001 3.001 0 0 1 0 5.658v10.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-10.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-.17a1 1 0 0 1 1 -1z" />
                        </svg>
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    </div>

    <flux:modal name="employees-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры сотрудников</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="applyFilters">
                <flux:input icon="magnifying-glass" placeholder="Имя или телефон" clearable label="Поиск"
                    wire:model.defer="search" />
                <flux:select label="Роль" wire:model.defer="roleFilter" placeholder="Все роли">
                    <flux:select.option value="">Все роли</flux:select.option>
                    <flux:select.option value="admin">Администратор</flux:select.option>
                    <flux:select.option value="deliver">Курьер</flux:select.option>
                    <flux:select.option value="manager">Менеджер</flux:select.option>
                    <flux:select.option value="cashier">Кассир</flux:select.option>
                    <flux:select.option value="applicant">Заявщик</flux:select.option>
                </flux:select>
                <flux:select label="Склад" wire:model.defer="warehouseFilter" placeholder="Все склады">
                    <flux:select.option value="">Все склады</flux:select.option>
                    @foreach ($this->warehouses as $warehouse)
                        <flux:select.option value="{{ $warehouse->id }}">{{ $warehouse->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:select label="Статус" wire:model.defer="statusFilter" placeholder="Все статусы">
                    <flux:select.option value="">Все статусы</flux:select.option>
                    <flux:select.option value="1">Активный</flux:select.option>
                    <flux:select.option value="0">Отключен</flux:select.option>
                </flux:select>
                <flux:select label="Сортировка" wire:model.defer="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="name">По имени</flux:select.option>
                    <flux:select.option value="phone">По телефону</flux:select.option>
                    <flux:select.option value="role">По роли</flux:select.option>
                    <flux:select.option value="status">По статусу</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.defer="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>
                <flux:select label="На странице" wire:model.defer="perPage">
                    <flux:select.option value="50">50</flux:select.option>
                    <flux:select.option value="100">100</flux:select.option>
                    <flux:select.option value="200">200</flux:select.option>
                </flux:select>

                <div class="grid grid-cols-1 gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="primary" color="lime" class="w-full" type="button"
                            wire:click="applyFilters">
                            Применить фильтр
                        </flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>

    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">


        <flux:table :paginate="$this->users">
            <flux:table.columns>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Рол</flux:table.column>
                <flux:table.column>Склад</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->users as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->name }}</flux:table.cell>
                        <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                        <flux:table.cell>{{ $item->role }}</flux:table.cell>
                        <flux:table.cell>{{ $item->warehouse?->name ?? 'Не назначен' }}</flux:table.cell>
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
                        <flux:table.cell>
                            <div class="flex items-center justify-end gap-2">
                                <flux:modal.trigger name="edit-employee" wire:click="openEdit({{ $item->id }})">
                                    <flux:button variant="primary" color="blue" size="sm" square
                                        icon="pencil-square" icon:class="!text-white" class="!text-white" />
                                </flux:modal.trigger>
                                <flux:modal.trigger name="confirm-employee-delete">
                                    <flux:button variant="danger" size="sm" square icon="trash"
                                        icon:class="!text-white" class="!text-white"
                                        wire:click="confirmDelete({{ $item->id }})" />
                                </flux:modal.trigger>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <flux:modal name="confirm-employee-delete" class="md:w-[28rem]">
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <flux:icon icon="trash" variant="mini" />
                </div>

                <div class="space-y-1">
                    <flux:heading>Удалить сотрудника?</flux:heading>
                    <flux:text class="text-sm text-zinc-600">
                        @if ($employeeToDeleteName)
                            Будет удален сотрудник <span class="font-semibold">{{ $employeeToDeleteName }}</span>
                            @if ($employeeToDeletePhone)
                                ({{ $employeeToDeletePhone }})
                            @endif.
                        @endif
                        Это действие нельзя отменить.
                    </flux:text>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost" wire:click="clearDeleteSelection">Отмена</flux:button>
                </flux:modal.close>

                <flux:modal.close>
                    <flux:button variant="danger" icon="trash" wire:click="deleteSelected"
                        :disabled="$employeeToDelete === null">
                        Удалить
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>


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
            <flux:select label="Склад" placeholder="Выберите склад..." wire:model="warehouse_id">
                @foreach ($this->warehouses as $warehouse)
                    <flux:select.option value="{{ $warehouse->id }}">{{ $warehouse->name }}</flux:select.option>
                @endforeach
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
            <flux:select label="Склад" placeholder="Выберите склад..." wire:model="editWarehouseId">
                @foreach ($this->warehouses as $warehouse)
                    <flux:select.option value="{{ $warehouse->id }}">{{ $warehouse->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input label="Telegram Chat Id" placeholder="Введите Telegram Chat Id"
                wire:model.defer="editChatId" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary" wire:click="updateEmployee">
                    Сохранить изменения
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
