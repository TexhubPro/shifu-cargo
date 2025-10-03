<div>
    <flux:heading>Часто задаваемые вопросы</flux:heading>
    <flux:text>Найдите ответы на популярные вопросы о наших услугах</flux:text>
    <flux:accordion class="mt-5">
        @foreach($faqs as $faq)
        <flux:accordion.item>
            <flux:accordion.heading>{{ $faq->question }}</flux:accordion.heading>
            <flux:accordion.content>
                {{ $faq->answer }}
            </flux:accordion.content>
        </flux:accordion.item>
        @endforeach
    </flux:accordion>
</div>