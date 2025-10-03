<div>
    <flux:heading>Проверить статус посылки</flux:heading>
    <flux:text>Узнайте, где находится ваша посылка прямо сейчас</flux:text>
    <form wire:submit="check" class="bg-neutral-800 border border-neutral-700 rounded-xl p-2 mt-4 space-y-3">
        <flux:input label="Трек-код" wire:model="trackcode" placeholder="Введите трек-код" required />
        <flux:button variant="primary" type="submit" color="lime" class="w-full">Проверить трек-код</flux:button>
    </form>
</div>