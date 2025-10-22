<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Faq;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\Queue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $settings = [
            ['name' => 'kg_price', 'content' => '3$'],
            ['name' => 'kg_price_10', 'content' => '2.5$'],
            ['name' => 'kg_price_20', 'content' => '2$'],
            ['name' => 'kg_price_30', 'content' => '1.5$'],
            ['name' => 'cube_price', 'content' => '260$'],
            ['name' => 'address_ivu', 'content' => 'test'],
            ['name' => 'address_dushanbe', 'content' => 'test'],
            ['name' => 'danger_products', 'content' => 'test'],
            ['name' => 'course_dollar', 'content' => '10'],
            ['name' => 'queue', 'content' => '0053350'],
        ];
        Setting::insert($settings);
        User::create([
            'name' => "Shodmehr",
            'code' => "0001",
            'phone' => '005335051',
            'password' => Hash::make('005335051'),
            'role' => 'admin'
        ]);
    }
}
