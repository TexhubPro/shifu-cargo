<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex flex-col gap-2">
            <flux:heading class="text-xl">Часто задаваемые вопросы</flux:heading>
            <flux:text class="text-sm" variant="subtle">
                Управляйте списком вопросов и ответов, которые видят пользователи.
            </flux:text>
        </div>
        <flux:modal.trigger name="edit-profile">
            <flux:button variant="primary" color="lime">Добавить</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @foreach ($faqs as $item)
            <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <flux:heading>{{ $item->question }}</flux:heading>
                        <flux:text class="mt-2 text-sm text-gray-600">{{ $item->answer }}</flux:text>
                    </div>
                    <flux:button wire:click="delete({{ $item->id }})" wire:confirm variant="primary" color="red" size="xs">
                        Удалить
                    </flux:button>
                </div>
            </div>
        @endforeach
    </div>


    <flux:modal name="edit-profile" class="md:w-96">
        <form wire:submit="add" class="space-y-6">
            <div>
                <flux:heading size="lg">Добавление вопроса</flux:heading>
                <flux:text class="mt-2">
                    Заполните поля для нового вопроса и ответа — они появятся в списке.
                </flux:text>
            </div>

            <flux:input label="Вопрос" placeholder="Введите вопрос" required wire:model="question" />
            <flux:textarea wire:model="answer" label="Ответ" placeholder="Введите ответ" required />

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">
                    Добавить вопрос
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
