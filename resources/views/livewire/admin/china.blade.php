<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Склад Китай</flux:heading>
        <flux:text class="text-base" variant="subtle">
            Добавление трек-кодов на склад в Китае. Вы можете загрузить Excel-файл с кодами или ввести их по
            отдельности.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <div>
            <flux:heading>Добавление трек-кодов</flux:heading>
            <flux:text>Выберите способ добавления трек-кодов — загрузка Excel-файла или ввод по отдельности.</flux:text>
        </div>
        <flux:tab.group>
            <flux:tabs variant="segmented">
                <flux:tab name="excel">Excel файл</flux:tab>
                <flux:tab name="manual">По отдельности</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="excel">
                <form class="space-y-3" wire:submit.prevent="importExcel">
                    <flux:date-picker wire:model="date" required />
                    <flux:input type="file" wire:model="excelfile" label="Выберите Excel файл" required />
                    <flux:button variant="primary" color="lime" class="w-full" type="submit">
                        Загрузить файл
                    </flux:button>
                </form>
            </flux:tab.panel>
            <flux:tab.panel name="manual">
                <form class="space-y-3" wire:submit.prevent="addSingleTrack">
                    <flux:input icon="qr-code" placeholder="Сканируйте штрихкод или введите трек-код вручную" clearable
                        label="Трек-код" wire:model="singleTrack" required />
                    <flux:button variant="primary" color="lime" class="w-full" type="submit">
                        Добавить трек-код
                    </flux:button>
                </form>
            </flux:tab.panel>
        </flux:tab.group>

    </div>
</div>
