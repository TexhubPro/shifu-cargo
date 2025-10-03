<div>
    <flux:heading>Калькулятор доставки</flux:heading>
    <flux:text>Рассчитайте стоимость и сроки доставки вашего груза</flux:text>
    <div class="mt-5 bg-neutral-800 border border-neutral-700 rounded-xl p-2">
        <flux:text color="red">
            Если объём груза большой, а вес маленький — стоимость рассчитывается по объёму.
            Если вес большой, а объём маленький — рассчитывается по весу.
        </flux:text>
        <flux:tab.group class="mt-5 w-full">
            <flux:tabs variant="segmented">
                <flux:tab name="by-weight">По весу</flux:tab>
                <flux:tab name="by-volume">По объёму</flux:tab>
            </flux:tabs>

            <!-- Расчёт по весу -->
            <flux:tab.panel name="by-weight" class="space-y-3">
                <form wire:submit.prevent="calcWeight" class="space-y-3">
                    <flux:input wire:model="weight" required label="Вес (кг)" placeholder="Введите вес товара" />
                    <flux:button type="submit" variant="primary" color="lime" class="w-full">Рассчитать</flux:button>
                </form>

                @if($resultWeight)
                <flux:text color="blue">{{ $resultWeight }}</flux:text>
                @endif
            </flux:tab.panel>

            <!-- Расчёт по объёму -->
            <flux:tab.panel name="by-volume" class="space-y-3">
                <form wire:submit.prevent="calcVolume" class="space-y-3">
                    <flux:input wire:model="length" required label="Длина (см)" placeholder="Введите длину" />
                    <flux:input wire:model="width" required label="Ширина (см)" placeholder="Введите ширину" />
                    <flux:input wire:model="height" required label="Высота (см)" placeholder="Введите высоту" />
                    <flux:button type="submit" variant="primary" color="lime" class="w-full">Рассчитать</flux:button>
                </form>

                @if($resultVolume)
                <flux:text color="blue">{{ $resultVolume }}</flux:text>
                @endif
            </flux:tab.panel>
        </flux:tab.group>
    </div>
</div>