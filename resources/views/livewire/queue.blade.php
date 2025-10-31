<div class="screen" wire:poll.15s="updateData">
    <div class="header">
        Код подтверждения: <span>{{ $code->content }}</span>
    </div>

    <div>
        @if($navbats)
        <div class="grid">
            <div class="men">
                <h1>Мужчины</h1>
                <div class="list">
                    @foreach ($navbats as $item)
                    @if($item->sex == 'm')
                    @if($item->status == "Касса")
                    <div>
                        <p class="person active">{{ $item->no }} - {{ $item->user->name." <-" }}</p>
                    </div>
                    @else
                    <div>
                        <p class="person">{{ $item->no }} - {{ $item->user->name }}</p>
                    </div>
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="women">
                <h1>Женщины</h1>
                <div class="list">
                    @foreach ($navbats as $item)
                    @if($item->sex == 'z')
                    @if($item->status == "Касса")
                    <div>
                        <p class="person active">{{ $item->no }} - {{ $item->user->name." <-" }}</p>
                    </div>
                    @else
                    <div>
                        <p class="person">{{ $item->no }} - {{ $item->user->name }}</p>
                    </div>
                    @endif
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<style>
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        background: #ffffff;
        font-family: Arial, sans-serif;
    }

    .screen {
        height: 100vh;
        width: 100%;
        background: white;
    }

    .header {
        color: white;
        background-color: #84cc16;
        /* lime-500 */
        padding: 16px;
        text-align: center;
        text-transform: uppercase;
        font-size: 2.5rem;
        font-weight: bold;
    }

    .header span {
        color: #ef4444;
        /* red-500 */
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        height: 100%;
    }

    .men,
    .women {
        padding: 20px;
        height: 100%;
        color: white;
    }

    .men {
        background-color: #3b82f6;
        /* blue-500 */
    }

    .women {
        background-color: #ef4444;
        /* red-500 */
    }

    h1 {
        font-size: 3rem;
        font-weight: bold;
        text-transform: uppercase;
        color: white;
        margin-bottom: 20px;
        border-bottom: 2px solid white;
        padding-bottom: 20px;
    }

    .list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        color: white;
    }

    .person {
        font-size: 3rem;
        font-weight: bold;
    }

    .person.active {
        color: #a3e635;
        /* lime-400 */
    }
</style>