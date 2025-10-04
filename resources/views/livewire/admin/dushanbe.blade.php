<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Склад Душанбе</flux:heading>
        <flux:text class="text-base" variant="subtle">Информация о товарах, прибывших или ожидающих выдачи в Душанбе.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <div>
            <flux:heading>Добавление и списание товаров</flux:heading>
            <flux:text>Из Excel-файла для склада Душанбе</flux:text>

            <flux:tab.group class="mt-5">
                <flux:tabs variant="segmented">
                    <flux:tab name="all">Все товары</flux:tab>
                    <flux:tab name="excel">Добавить</flux:tab>
                    <flux:tab name="writeoff">Списать</flux:tab>
                </flux:tabs>

                <!-- 🔹 Вкладка 1: Добавление через Excel -->
                <flux:tab.panel name="all">
                    <form class="space-y-3" wire:submit.prevent="addSingleTrack">
                        <flux:input icon="user-circle" placeholder="Специалный код клиента" clearable
                            label="Специалный код клиента" wire:model="singleTrack" required />
                        <flux:button variant="primary" color="lime" class="w-full" type="submit">
                            Проверить
                        </flux:button>
                    </form>
                    <flux:table class="mt-5">
                        <flux:table.columns>
                            <flux:table.column>Customer</flux:table.column>
                            <flux:table.column>Date</flux:table.column>
                            <flux:table.column>Status</flux:table.column>
                            <flux:table.column>Amount</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            <flux:table.row>
                                <flux:table.cell>Lindsey Aminoff</flux:table.cell>
                                <flux:table.cell>Jul 29, 10:45 AM</flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell variant="strong">$49.00</flux:table.cell>
                            </flux:table.row>

                            <flux:table.row>
                                <flux:table.cell>Hanna Lubin</flux:table.cell>
                                <flux:table.cell>Jul 28, 2:15 PM</flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell variant="strong">$312.00</flux:table.cell>
                            </flux:table.row>

                            <flux:table.row>
                                <flux:table.cell>Kianna Bushevi</flux:table.cell>
                                <flux:table.cell>Jul 30, 4:05 PM</flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge color="zinc" size="sm" inset="top bottom">Refunded</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell variant="strong">$132.00</flux:table.cell>
                            </flux:table.row>

                            <flux:table.row>
                                <flux:table.cell>Gustavo Geidt</flux:table.cell>
                                <flux:table.cell>Jul 27, 9:30 AM</flux:table.cell>
                                <flux:table.cell>
                                    <flux:badge color="green" size="sm" inset="top bottom">Paid</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell variant="strong">$31.00</flux:table.cell>
                            </flux:table.row>
                        </flux:table.rows>
                    </flux:table>
                </flux:tab.panel>
                <flux:tab.panel name="excel">
                    <form class="space-y-3" wire:submit.prevent="importExcel">
                        <!-- 🔹 Выбор диапазона дат рейса -->
                        <flux:date-picker mode="range" label="Выберите даты рейса" wire:model="flightDates" required />

                        <!-- 🔹 Загрузка Excel файла -->
                        <flux:input type="file" wire:model="excelFile" label="Выберите Excel файл" required
                            accept=".xlsx,.xls,.csv" />

                        <!-- 🔹 Кнопка отправки -->
                        <flux:button variant="primary" color="lime" class="w-full" type="submit">
                            Загрузить файл
                        </flux:button>
                    </form>
                </flux:tab.panel>

                <!-- 🔹 Вкладка 2: Списание товара -->
                <flux:tab.panel name="writeoff">
                    <form class="space-y-3" wire:submit.prevent="writeOffItem">
                        <flux:input type="file" wire:model="excelFilewriteOffItem" label="Выберите Excel файл" required
                            accept=".xlsx,.xls,.csv" />
                        <flux:button variant="primary" color="red" class="w-full" type="submit">
                            Списать товары
                        </flux:button>
                    </form>
                </flux:tab.panel>


            </flux:tab.group>
        </div>


    </div>
</div>