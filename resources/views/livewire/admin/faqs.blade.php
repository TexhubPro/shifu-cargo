<div>
    <div class="mb-5 flex justify-between items-center gap-5">
        <div>
            <flux:heading class="text-xl">Часто задаваемые вопросы</flux:heading>
            <flux:text class="text-base" variant="subtle">
                На этой странице можно добавить новые вопросы и ответы, которые будут доступны пользователям в разделе
                «Часто
                задаваемые вопросы».
            </flux:text>
        </div>
        <flux:modal.trigger name="edit-profile">
            <flux:button variant="primary" color="lime">Добавить</flux:button>
        </flux:modal.trigger>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 space-y-3">
        @foreach ($faqs as $item)
        <div class="flex justify-between gap-5">
            <div>
                <flux:heading>{{ $item->question }}</flux:heading>
                <flux:text class="">{{ $item->answer }}</flux:text>
            </div>
            <flux:button wire:click="delete({{ $item->id }})" wire:confirm variant="primary" color="red" size="xs">
                Удалить
            </flux:button>
        </div>
        @endforeach
    </div>


    <flux:modal name="edit-profile" class="md:w-96">
        <form wire:submit="add" class="space-y-6">
            <div>
                <flux:heading size="lg">Добавление вопроса</flux:heading>
                <flux:text class="mt-2">Заполните поля для нового вопроса и его ответа, чтобы он появился в разделе
                    «Часто
                    задаваемые вопросы».</flux:text>
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