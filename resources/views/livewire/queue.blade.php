<div class="h-screen w-full bg-white" wire:poll.15s="updateData">
    <div class="text-white bg-lime-500 p-4 text-4xl uppercase font-bold text-center">
        Код подтверждения: <span class="text-red-500">{{ $code->content }}</span>
    </div>

    <div class="">
        @if($navbats)
        <div class="grid grid-cols-2 h-full">
            <div class="bg-blue-500 p-5 h-full">
                <h1 class="text-5xl font-bold uppercase text-white my-5">Мужчины</h1>
                <div class="space-y-3 text-white">
                    @foreach ($navbats as $item)
                    @if($item->sex == 'm')
                    <div class="grid grid-cols-1">
                        <p class="text-5xl font-bold">{{ $item->no }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="bg-red-500 p-5 h-full">
                <h1 class="text-5xl font-bold uppercase text-white my-5">Женщины</h1>
                <div class="space-y-3 text-white">
                    @foreach ($navbats as $item)
                    @if($item->sex == 'z')
                    <div class="grid grid-cols-1">
                        <p class="text-5xl font-bold">{{ $item->no }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>