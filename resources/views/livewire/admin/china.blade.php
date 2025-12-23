<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Склад Китай</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Добавление трек-кодов на склад в Китае. Загрузите Excel-файл или добавьте трек-коды вручную.
        </flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Добавление трек-кодов</flux:heading>
            <flux:text>Выберите способ добавления: Excel-файл или ручной ввод.</flux:text>
        </div>

        <flux:tab.group>
            <flux:tabs variant="segmented">
                <flux:tab name="excel">Excel файл</flux:tab>
                <flux:tab name="manual">По отдельности</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="excel">
                <form class="space-y-4" wire:submit.prevent="importExcel">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <flux:date-picker wire:model.live="date" required label="Выберите дату" />
                        <flux:input type="file" wire:model="excelfile" label="Выберите Excel файл" required />
                    </div>
                    <flux:button variant="primary" color="lime" class="w-full lg:w-auto" type="submit">
                        Загрузить файл
                    </flux:button>
                </form>
            </flux:tab.panel>
            <flux:tab.panel name="manual">
                <form class="space-y-4" wire:submit.prevent="addSingleTrack">
                    <flux:input icon="qr-code" placeholder="Сканируйте штрихкод или введите трек-код вручную" clearable
                        label="Трек-код" wire:model="singleTrack" required />
                    <flux:button variant="primary" color="lime" class="w-full lg:w-auto" type="submit">
                        Добавить трек-код
                    </flux:button>
                </form>
            </flux:tab.panel>
        </flux:tab.group>
    </div>
</div>
