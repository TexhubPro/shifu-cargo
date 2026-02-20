<div class="space-y-6">
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Заявки на доставку</flux:heading>

            <div class="flex items-center gap-2">
                <flux:button variant="primary" color="blue" size="base" icon="arrow-down-on-square-stack"
                    icon:class="!text-white" class="!text-white" wire:click="downloadReport">
                    Отчёт
                </flux:button>

                <flux:modal.trigger name="confirm-clean-invalid">
                    <flux:button variant="primary" color="blue" size="base" class="!text-white">
                        Очистить недопустимые поля
                    </flux:button>
                </flux:modal.trigger>

                <flux:modal.trigger name="applications-filters">
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

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4">
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Заявки сегодня</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <flux:icon icon="clipboard-document-list" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">{{ $this->todayStats['applications'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Оформлено сегодня</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                        <flux:icon icon="check-circle" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">{{ $this->todayStats['completed'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Сумма заказа сегодня</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                        <flux:icon icon="document-currency-dollar" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($this->todayStats['subtotal'], 2, '.', ' ') }} c
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Сумма доставки сегодня</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100">
                        <flux:icon icon="truck" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($this->todayStats['delivery'], 2, '.', ' ') }} c
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Поступления доставщиков</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 ring-1 ring-cyan-100">
                        <flux:icon icon="wallet" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($this->todayStats['deliverer_payments'], 2, '.', ' ') }} c
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Итог сегодня</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-600 ring-1 ring-rose-100">
                        <flux:icon icon="chart-bar-square" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($this->todayStats['revenue'], 2, '.', ' ') }} c
                </p>
            </div>
        </div>
    </div>

    <flux:modal name="applications-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры заявок</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="applyFilters">
                <flux:input icon="user" placeholder="Имя клиента" clearable label="Поиск по имени"
                    wire:model.defer="searchName" />
                <flux:input icon="phone" placeholder="Телефон" clearable label="Поиск по телефону"
                    wire:model.defer="searchPhone" />
                <flux:select label="Статус" wire:model.defer="status" placeholder="Все статусы">
                    <flux:select.option value="">Все статусы</flux:select.option>
                    <flux:select.option value="В ожидании">В ожидании</flux:select.option>
                    <flux:select.option value="Собрано">Собрано</flux:select.option>
                    <flux:select.option value="У доставщика">У доставщика</flux:select.option>
                    <flux:select.option value="Доставлено">Доставлено</flux:select.option>
                    <flux:select.option value="Отменено">Отменено</flux:select.option>
                </flux:select>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <flux:date-picker label="Дата от" wire:model.defer="dateFrom" />
                    <flux:date-picker label="Дата до" wire:model.defer="dateTo" />
                </div>
                <flux:select label="Сортировка" wire:model.defer="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="name">По имени</flux:select.option>
                    <flux:select.option value="status">По статусу</flux:select.option>
                    <flux:select.option value="phone">По телефону</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.defer="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
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
        <flux:table :paginate="$this->orders">
            <flux:table.columns>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Номер тел</flux:table.column>
                <flux:table.column>Адрес</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->orders as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->user->code ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->phone }}</flux:table.cell>
                        <flux:table.cell class="max-w-48 overflow-hidden truncate">{{ $item->address }}
                        </flux:table.cell>

                        <flux:table.cell>
                            @switch($item->status)
                                @case('В ожидании')
                                    <flux:badge color="orange" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Собрано')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('У доставщика')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Доставлено')
                                    <flux:badge color="emerald" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @default
                                    <flux:badge color="yellow" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                            @endswitch
                        </flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                        </flux:table.cell>
                        @if (Auth::user()->role == 'admin')
                            <flux:table.cell>
                                <div class="flex items-center gap-2 justify-end">
                                    <flux:button variant="primary" size="sm" color="lime"
                                        wire:click="activate({{ $item->id }})">
                                        Активировать
                                    </flux:button>
                                    <flux:button variant="primary" color="blue" size="sm" square
                                        icon="eye" icon:class="!text-white" class="!text-white"
                                        href="{{ route('admin.applications.show', $item->id) }}" />
                                    <flux:modal.trigger name="confirm-application-delete">
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

    <flux:modal name="confirm-application-delete" class="md:w-[28rem]">
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <flux:icon icon="trash" variant="mini" />
                </div>

                <div class="space-y-1">
                    <flux:heading>Удалить заявку?</flux:heading>
                    <flux:text class="text-sm text-zinc-600">
                        @if ($applicationDeleteClient)
                            Будет удалена заявка клиента <span
                                class="font-semibold">{{ $applicationDeleteClient }}</span>
                            @if ($applicationDeletePhone)
                                ({{ $applicationDeletePhone }})
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
                        :disabled="$applicationToDelete === null">
                        Удалить
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>

    <flux:modal name="confirm-clean-invalid" class="md:w-[30rem]">
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <flux:icon icon="trash" variant="mini" />
                </div>

                <div class="space-y-1">
                    <flux:heading>Очистить недопустимые заявки?</flux:heading>
                    <flux:text class="text-sm text-zinc-600">
                        Будут удалены отмененные и некорректные заявки.
                    </flux:text>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Отмена</flux:button>
                </flux:modal.close>

                <flux:modal.close>
                    <flux:button variant="danger" icon="trash" wire:click="cleanInvalid">
                        Очистить
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
