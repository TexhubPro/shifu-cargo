<div>
    <div class="mb-5">
        <flux:heading class="text-xl">СМС рассылка</flux:heading>
        <flux:text class="text-base" variant="subtle">
            Массовая отправка уведомлений и оповещений клиентам через SMS.
        </flux:text>
    </div>
    <div class="bg-white p-2 rounded-xl border border-gray-200 space-y-3">
        <form class="space-y-3" wire:submit.prevent="sendSms">
            <flux:textarea label="Текст сообщения" placeholder="Введите текст SMS для клиентов..." wire:model="smsText"
                required />
            <flux:button variant="primary" color="lime" class="w-full" type="submit">
                Отправить
            </flux:button>
        </form>
    </div>
</div>