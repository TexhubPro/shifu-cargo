<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    protected $model = \App\Models\Faq::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faqs = [
            [
                'question' => 'Как оформить заказ?',
                'answer' => 'Чтобы оформить заказ, зарегистрируйтесь, выберите товары и укажите адрес доставки.',
            ],
            [
                'question' => 'Какие способы оплаты доступны?',
                'answer' => 'Вы можете оплатить картой, через терминал или онлайн-банкинг.',
            ],
            [
                'question' => 'Как отслеживать свой заказ?',
                'answer' => 'После отправки вы получите трек-код, по которому можно отслеживать доставку.',
            ],
            [
                'question' => 'Можно ли изменить адрес доставки?',
                'answer' => 'Да, изменить адрес можно до момента отправки заказа через личный кабинет.',
            ],
            [
                'question' => 'Что делать, если заказ не пришёл?',
                'answer' => 'Свяжитесь с нашей поддержкой, и мы проверим статус вашего заказа.',
            ],
        ];

        // Выбираем случайный вопрос из массива
        return $faqs[array_rand($faqs)];
    }
}
