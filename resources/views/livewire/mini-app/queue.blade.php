<div>
    <flux:heading>Взять электронную очередь</flux:heading>
    <flux:text>Введите код с экрана телевизора в нашем пункте выдачи и получите свою очередь.</flux:text>
    @if($queue)
    <div class="bg-neutral-800 border border-neutral-700 rounded-xl p-2 mt-5 space-y-3">
        <h1 class="text-9xl text-center text-white font-bold">{{ $queue->no }}</h1>
        <flux:button wire:click="delete({{ $queue->id }})" variant="primary" color="red" class="w-full">Отменить очередь
        </flux:button>
    </div>
    @else
    <form wire:submit="load" class="bg-neutral-800 border border-neutral-700 rounded-xl p-2 mt-5 space-y-3">
        <flux:input wire:model="code" required label="Код подтвержления" placeholder="Введите код" />
        <flux:button type="submit" variant="primary" color="lime" class="w-full">Взять очередь</flux:button>
    </form>
    @endif
</div>