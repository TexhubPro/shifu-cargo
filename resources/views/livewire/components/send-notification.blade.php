<div class="p-4 bg-neutral-800 rounded-xl space-y-4">
    <h2 class="text-xl font-semibold text-white">Отправка уведомления</h2>

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block text-gray-300">ID пользователя</label>
            <input type="number" wire:model="user_id" class="w-full rounded p-2 bg-neutral-700 text-white" required>
        </div>

        <div>
            <label class="block text-gray-300">Текст уведомления</label>
            <textarea wire:model="content" rows="3" class="w-full rounded p-2 bg-neutral-700 text-white"
                required></textarea>
        </div>

        <button type="submit" class="w-full bg-lime-500 hover:bg-lime-600 text-black font-bold py-2 px-4 rounded">
            Отправить
        </button>
    </form>
</div>