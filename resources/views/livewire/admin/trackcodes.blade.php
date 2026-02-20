<div class="space-y-4">
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Трек-коды</flux:heading>

            <flux:modal.trigger name="trackcode-filters">
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

    <flux:modal name="trackcode-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры трек-кодов</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="search_form">
                <flux:input icon="qr-code" placeholder="Введите трек-код" clearable label="Поиск по трек-коду"
                    wire:model.defer="search" />
                <flux:input icon="user-circle" placeholder="Код клиента" clearable label="Поиск по коду клиента"
                    wire:model.defer="user_code" />
                <flux:select label="Статус" wire:model.defer="status" placeholder="Все статусы">
                    <flux:select.option value="">Все статусы</flux:select.option>
                    <flux:select.option value="В ожидании">В ожидании</flux:select.option>
                    <flux:select.option value="Получено в Иву">Получено в Иву</flux:select.option>
                    <flux:select.option value="В пункте выдачи">В пункте выдачи</flux:select.option>
                    <flux:select.option value="Получено">Получено</flux:select.option>
                </flux:select>
                <flux:select label="Сортировка" wire:model.defer="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="code">По трек-коду</flux:select.option>
                    <flux:select.option value="status">По статусу</flux:select.option>
                    <flux:select.option value="user_id">По клиенту</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.defer="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>

                <div class="grid grid-cols-1 gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="primary" color="lime" class="w-full" type="button"
                            wire:click="checkUser">
                            Применить фильтр
                        </flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>

    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100 space-y-4">


        <flux:table :paginate="$this->trackcodes" class="">
            <flux:table.columns>
                <flux:table.column>Трек-код</flux:table.column>
                <flux:table.column>Клиент</flux:table.column>
                <flux:table.column>Статус</flux:table.column>
                <flux:table.column>Дата получения</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->trackcodes as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->code }}</flux:table.cell>
                        <flux:table.cell>{{ $item->user->code ?? 'Не известно' }}</flux:table.cell>
                        <flux:table.cell>
                            @switch($item->status)
                                @case('В ожидании')
                                    <flux:badge color="orange" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Получено в Иву')
                                    <flux:badge color="lime" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('В пункте выдачи')
                                    <flux:badge color="blue" size="sm" inset="top bottom">
                                        {{ $item->status }}
                                    </flux:badge>
                                @break

                                @case('Получено')
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
                                <flux:modal.trigger name="confirm-trackcode-delete">
                                    <flux:button variant="danger" size="sm" square icon="trash"
                                        wire:click="confirmDelete({{ $item->id }})" />
                                </flux:modal.trigger>
                            </flux:table.cell>
                        @endif
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>

    <flux:modal name="confirm-trackcode-delete" class="md:w-[28rem]">
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <flux:icon icon="trash" variant="mini" />
                </div>

                <div class="space-y-1">
                    <flux:heading>Удалить трек-код?</flux:heading>
                    <flux:text class="text-sm text-zinc-600">
                        @if ($trackcodeToDeleteCode)
                            Будет удален трек-код <span class="font-semibold">{{ $trackcodeToDeleteCode }}</span>.
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
                        :disabled="$trackcodeToDelete === null">
                        Удалить
                    </flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
