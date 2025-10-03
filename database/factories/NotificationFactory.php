<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Notification::class;

    public function definition(): array
    {
        $notifications = [
            'Ваш заказ принят и будет обработан в ближайшее время.',
            'Ваш груз прибыл на склад в Душанбе.',
            'Заказ №123 успешно доставлен.',
            'Обновление статуса: ваш груз ожидает выдачи в пункте Иву.',
            'Напоминаем: оплатите доставку, чтобы получить заказ вовремя.',
            'Ваш запрос на возврат успешно обработан.',
            'Новое уведомление от Shuhrat Cargo: проверьте детали заказа.',
        ];

        // Выбираем случайное уведомление
        $content = $notifications[array_rand($notifications)];
        return [
            'user_id' => '1',
            'content' => $content,
        ];
    }
}
