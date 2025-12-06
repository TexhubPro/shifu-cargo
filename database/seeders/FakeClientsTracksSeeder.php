<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Trackcode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FakeClientsTracksSeeder extends Seeder
{
    /**
     * Seed 10 fake customer users and 10 trackcodes without generating any orders.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('ru_RU');

        $clients = collect(range(1, 10))->map(function () use ($faker) {
            return User::create([
                'name' => $faker->unique()->name(),
                'phone' => $faker->unique()->regexify('9[0-9]{8}'),
                'code' => str_pad((string) $faker->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
                'role' => 'customer',
                'password' => Hash::make('password'),
                'status' => true,
            ]);
        });

        $userIds = $clients->pluck('id');
        $statuses = ['Получено', 'В пути', 'На складе Китая'];

        foreach (range(1, 10) as $index) {
            $chinaDate = Carbon::now()->subDays(rand(7, 20));
            $dushanbeDate = (clone $chinaDate)->addDays(rand(1, 5));

            Trackcode::create([
                'code' => 'TRK' . strtoupper(Str::random(7)),
                'user_id' => $userIds->random(),
                'status' => $faker->randomElement($statuses),
                'china' => $chinaDate->toDateTimeString(),
                'dushanbe' => $dushanbeDate->toDateTimeString(),
                'customer' => null,
                'weight' => number_format($faker->randomFloat(2, 0.5, 15), 2, '.', ''),
            ]);
        }

        foreach (range(1, 10) as $index) {
            $client = $clients->random();

            Application::create([
                'user_id' => $client->id,
                'phone' => $client->phone ?? $faker->regexify('9[0-9]{8}'),
                'address' => $faker->streetAddress(),
                'note' => $faker->sentence(8),
                'latitude' => $faker->latitude(37.0, 38.9),
                'longitude' => $faker->longitude(68.5, 71.5),
                'status' => 'В ожидании',
            ]);
        }
    }
}
