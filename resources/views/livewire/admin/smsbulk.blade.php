<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">СМС рассылка</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Массовая отправка уведомлений и оповещений клиентам через SMS.
        </flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100 space-y-4">
        <div class="flex flex-col gap-1">
            <flux:heading>Создать рассылку</flux:heading>
            <flux:text>Введите текст сообщения и отправьте клиентам.</flux:text>
        </div>

        <form class="space-y-4" wire:submit.prevent="smsbulk">
            <flux:textarea label="Текст сообщения" placeholder="Введите текст SMS для клиентов..." wire:model="message"
                required />
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p class="text-xs text-gray-500">
                    Рекомендуем до 160 символов, чтобы сообщение поместилось в один SMS.
                </p>
                <flux:button variant="primary" color="lime" class="w-full sm:w-auto" type="submit">
                    Отправить
                </flux:button>
            </div>
        </form>
    </div>
</div>
