<div class="space-y-6">
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Клиенты и коды</flux:heading>

            <flux:modal.trigger name="customers-filters">
                <flux:button variant="primary" color="lime" square size="base" class="shrink-0">
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

    <flux:modal name="customers-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры клиентов</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="check_user">
                <flux:input icon="user" placeholder="Введите имя" clearable label="Поиск по имени"
                    wire:model.defer="nameSearch" />
                <flux:input icon="phone" placeholder="Введите телефон" clearable label="Поиск по телефону"
                    wire:model.defer="phoneSearch" />
                <flux:input placeholder="Введите код" clearable label="Поиск по коду" wire:model.defer="codeSearch" />
                <flux:select label="Пол" wire:model.defer="sex" placeholder="Все">
                    <flux:select.option value="">Все</flux:select.option>
                    <flux:select.option value="m">Мужской</flux:select.option>
                    <flux:select.option value="z">Женский</flux:select.option>
                </flux:select>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <flux:date-picker label="Дата от" wire:model.defer="dateFrom" />
                    <flux:date-picker label="Дата до" wire:model.defer="dateTo" />
                </div>
                <flux:select label="Сортировка" wire:model.defer="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="name">По имени</flux:select.option>
                    <flux:select.option value="code">По коду</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.defer="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>
                <div class="grid grid-cols-1 gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="primary" color="lime" class="w-full" type="button"
                            wire:click="check_user">
                            Применить фильтр
                        </flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>

    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <flux:table :paginate="$this->customers">
            <flux:table.columns>
                <flux:table.column>Код</flux:table.column>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Пол</flux:table.column>
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
                        <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                        </flux:table.cell>
                        @if (Auth::user()->role == 'admin')
                            <flux:table.cell>
                                <div class="flex items-center gap-2 justify-end">
                                    <flux:button variant="outline" size="sm" square icon="eye"
                                        href="{{ route('admin.customers.show', $item->id) }}" />
                                    <flux:modal.trigger name="confirm-customer-delete">
                                        <flux:button variant="danger" size="sm" square icon="trash"
                                            wire:click="confirmDelete({{ $item->id }})" />
                                    </flux:modal.trigger>
                                </div>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <flux:modal name="confirm-customer-delete" class="md:w-[28rem]">
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <flux:icon icon="trash" variant="mini" />
                </div>

                <div class="space-y-1">
                    <flux:heading>Удалить клиента?</flux:heading>
                    <flux:text class="text-sm text-zinc-600">
                        @if ($customerToDeleteName)
                            Будет удален клиент <span class="font-semibold">{{ $customerToDeleteName }}</span>
                            @if ($customerToDeleteCode)
                                ({{ $customerToDeleteCode }})
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
                        :disabled="$customerToDelete === null">
                        Удалить
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
