<div>
    <flux:heading>Добавить новый трек-код</flux:heading>
    <flux:text>Введите информацию о посылке, чтобы начать отслеживание</flux:text>
    <form wire:submit="add" class="bg-neutral-800 border border-neutral-700 rounded-xl p-2 mt-4 space-y-3">
        <flux:input label="Трек-код" placeholder="Введите трек-код" required />
        <flux:button variant="primary" type="submit" color="lime" class="w-full">Добавить</flux:button>
    </form>
</div>