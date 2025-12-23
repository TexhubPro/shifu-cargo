<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-col gap-2">
            <flux:heading class="text-xl">Затраты</flux:heading>
            <flux:text class="text-sm" variant="subtle">
                Добавляйте и контролируйте записи о расходах по складам и кубатуре.
            </flux:text>
        </div>
        <flux:modal.trigger name="edit-profile">
            <flux:button variant="primary" color="lime">Добавить</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Фильтры и сортировка</flux:heading>
            <flux:text>Используйте фильтры для быстрого поиска нужных затрат.</flux:text>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <flux:input icon="magnifying-glass" placeholder="Сумма или описание" clearable label="Поиск"
                wire:model.live.debounce.400ms="search" />
            <flux:select label="Склад" wire:model.live="warehouseFilter" placeholder="Все склады">
                <flux:select.option value="">Все склады</flux:select.option>
                <flux:select.option value="Склад Душанбе">Склад Душанбе</flux:select.option>
                <flux:select.option value="Склад Иву">Склад Иву</flux:select.option>
                <flux:select.option value="Кубатура Иву">Кубатура Иву</flux:select.option>
                <flux:select.option value="Кубатура Душанбе">Кубатура Душанбе</flux:select.option>
            </flux:select>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <flux:date-picker label="Дата от" wire:model.live="dateFrom" />
                <flux:date-picker label="Дата до" wire:model.live="dateTo" />
            </div>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-3">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full lg:w-auto">
                <flux:select label="Сортировка" wire:model.live="sortField">
                    <flux:select.option value="created_at">По дате</flux:select.option>
                    <flux:select.option value="total">По сумме</flux:select.option>
                    <flux:select.option value="sklad">По складу</flux:select.option>
                    <flux:select.option value="data">По дате расхода</flux:select.option>
                </flux:select>
                <flux:select label="Направление" wire:model.live="sortDirection">
                    <flux:select.option value="desc">Сначала новые</flux:select.option>
                    <flux:select.option value="asc">Сначала старые</flux:select.option>
                </flux:select>
                <flux:select label="На странице" wire:model.live="perPage">
                    <flux:select.option value="25">25</flux:select.option>
                    <flux:select.option value="50">50</flux:select.option>
                    <flux:select.option value="100">100</flux:select.option>
                </flux:select>
            </div>
            <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                Всего: {{ $this->expences->total() }}
            </span>
        </div>

        <flux:table :paginate="$this->expences">
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
                <flux:table.column>Склад/Кубатура</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->expences as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->total }}c</flux:table.cell>
                        <flux:table.cell>{{ $item->content }}</flux:table.cell>
                        <flux:table.cell>{{ $item->sklad }}</flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->data }}
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
    <flux:modal name="edit-profile" class="md:w-96">
        <form wire:submit="addExpense" class="space-y-6">
            <div>
                <flux:heading size="lg">Добавление затрат</flux:heading>
                <flux:text class="mt-2">
                    Заполните поля, чтобы добавить новую запись о расходах, указав склад, сумму и описание затрат.
                </flux:text>
            </div>
            <flux:date-picker label="Выберите дата" wire:model="data" required />
            <flux:select label="Склад" placeholder="Выберите склад" required wire:model.live="warehouse">
                <flux:select.option value="Склад Душанбе">Склад Душанбе</flux:select.option>
                <flux:select.option value="Склад Иву">Склад Иву</flux:select.option>
                <flux:select.option value="Кубатура Иву">Кубатура Иву</flux:select.option>
                <flux:select.option value="Кубатура Душанбе">Кубатура Душанбе</flux:select.option>
            </flux:select>

            <!-- Сумма -->
            <flux:input type="number" label="Сумма" placeholder="Введите сумму" required wire:model="amount" />
            @if ($hidden == false)
                <!-- Описание -->
                <flux:textarea label="Описание" placeholder="Введите описание затрат" wire:model="description" />
            @endif

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">
                    Добавить затраты
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
