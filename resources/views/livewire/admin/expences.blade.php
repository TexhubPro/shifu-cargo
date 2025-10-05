<div>
    <div class="flex justify-between gap-5 items-center">
        <div>
            <flux:heading class="text-xl">Добавление затрат</flux:heading>
            <flux:text class="text-base" variant="subtle">
                На этой странице можно добавить новую запись о расходах, указав склад, сумму и описание затрат для
                точного
                учета.
            </flux:text>
        </div>
        <flux:modal.trigger name="edit-profile">
            <flux:button variant="primary" color="lime">Добавить</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3 mt-5">
        <flux:table :paginate="$this->expences" class="">
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
                <flux:table.column>Склад</flux:table.column>
                <flux:table.column>Дата</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->expences as $item)

                <flux:table.row>
                    <flux:table.cell>{{ $item->total }}</flux:table.cell>
                    <flux:table.cell>{{ $item->content }}</flux:table.cell>
                    <flux:table.cell>{{ $item->sklad }}</flux:table.cell>
                    <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                    </flux:table.cell>
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

            <!-- Выбор склада -->
            <flux:select label="Склад" placeholder="Выберите склад" required wire:model="warehouse">
                <flux:select.option value="Склад Душанбе">Склад Душанбе</flux:select.option>
                <flux:select.option value="Склад Иву">Склад Иву</flux:select.option>
                <!-- Можно динамически подгружать склады -->
            </flux:select>

            <!-- Сумма -->
            <flux:input type="number" label="Сумма" placeholder="Введите сумму" required wire:model="amount" />

            <!-- Описание -->
            <flux:textarea label="Описание" placeholder="Введите описание затрат" wire:model="description" />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">
                    Добавить затраты
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>