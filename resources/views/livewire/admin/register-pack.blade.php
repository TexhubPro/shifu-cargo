<div>
    <div class="mb-5">
        <flux:heading class="text-xl">Регистрация груза</flux:heading>
        <flux:text class="text-base" variant="subtle">
            Укажите информацию о грузе для оформления в города Иву или Душанбе.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <div>
            <flux:heading>Введите необходимую информацию</flux:heading>
            <flux:text>Чтобы зарегистрировать груз — укажите вес, тип и количество
                коробок.
            </flux:text>
        </div>
        <flux:tab.group>
            <flux:tabs variant="segmented">
                <flux:tab name="excel">Город Душанбе</flux:tab>
                <flux:tab name="manual">Город Иву</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="excel">
                <form class="space-y-3" wire:submit.prevent="registerDushanbe">
                    <flux:input icon="scale" type="number" step="0.1" label="Вес (кг)" placeholder="Введите вес груза"
                        wire:model="weight" required />

                    <flux:select label="Тип груза" wire:model="type" placeholder="Выберите тип" required>
                        <option value="малкий">Малкий</option>
                        <option value="крупный">Крупный</option>
                        <option value="штучно">Штучно</option>
                    </flux:select>

                    <flux:input icon="arrows-pointing-out" type="number" label="Количество коробок"
                        placeholder="Введите число коробок" wire:model="boxes" min="1" required />

                    <flux:button variant="primary" color="lime" class="w-full" type="submit">
                        Зарегистрировать груз
                    </flux:button>
                </form>
                <flux:table :paginate="$this->dushanbes" class="mt-10">
                    <flux:table.columns>
                        <flux:table.column>Склад</flux:table.column>
                        <flux:table.column>Весь груза</flux:table.column>
                        <flux:table.column>Тип груза</flux:table.column>
                        <flux:table.column>Коробки</flux:table.column>
                        <flux:table.column>Дата</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->dushanbes as $item)

                        <flux:table.row>
                            <flux:table.cell>{{ $item->sklad }}</flux:table.cell>
                            <flux:table.cell>{{ $item->weight }}кг</flux:table.cell>
                            <flux:table.cell>{{ $item->type }}</flux:table.cell>
                            <flux:table.cell>{{ $item->packages }}шт</flux:table.cell>
                            <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                            </flux:table.cell>
                        </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </flux:tab.panel>
            <flux:tab.panel name="manual">
                <form class="space-y-3" wire:submit.prevent="registerIvu">
                    <flux:input icon="scale" type="number" step="0.1" label="Вес (кг)" placeholder="Введите вес груза"
                        wire:model="ivuweight" required />

                    <flux:select label="Тип груза" wire:model="ivutype" placeholder="Выберите тип" required>
                        <option value="малкий">Малкий</option>
                        <option value="крупный">Крупный</option>
                        <option value="штучно">Штучно</option>
                    </flux:select>

                    <flux:input icon="arrows-pointing-out" type="number" label="Количество коробок"
                        placeholder="Введите число коробок" wire:model="ivuboxes" min="1" required />

                    <flux:button variant="primary" color="lime" class="w-full" type="submit">
                        Зарегистрировать груз
                    </flux:button>
                </form>
                <flux:table :paginate="$this->ivus" class="mt-10">
                    <flux:table.columns>
                        <flux:table.column>Склад</flux:table.column>
                        <flux:table.column>Весь груза</flux:table.column>
                        <flux:table.column>Тип груза</flux:table.column>
                        <flux:table.column>Коробки</flux:table.column>
                        <flux:table.column>Дата</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->ivus as $item)

                        <flux:table.row>
                            <flux:table.cell>{{ $item->sklad }}</flux:table.cell>
                            <flux:table.cell>{{ $item->weight }}кг</flux:table.cell>
                            <flux:table.cell>{{ $item->type }}</flux:table.cell>
                            <flux:table.cell>{{ $item->packages }}шт</flux:table.cell>
                            <flux:table.cell variant="strong">{{ $item->created_at->format('H:i | d.m.Y') }}
                            </flux:table.cell>
                        </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </flux:tab.panel>
        </flux:tab.group>

    </div>
</div>