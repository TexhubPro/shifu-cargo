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
            ['name' => 'cube_price', 'content' => '260$'],
            ['name' => 'address_ivu', 'content' => 'test'],
            ['name' => 'address_dushanbe', 'content' => 'test'],
            ['name' => 'danger_products', 'content' => 'test'],
            ['name' => 'course_dollar', 'content' => '10'],
            ['name' => 'queue', 'content' => '0053350'],
        ];
        Setting::insert($settings);
        Faq::factory()->count(10)->create();
        Notification::factory()->count(10)->create();
        User::create([
            'name' => "Shodmehr",
            'code' => "0001",
            'phone' => '005335051',
            'password' => Hash::make('005335051'),
            'role' => 'admin'
        ]);
        Chat::create([
            'user_id' => '1',
            'status' => true
        ]);
        Message::create([
            'chat_id' => '1',
            'message' => "Hello beby"
        ]);
        Message::create([
            'chat_id' => '1',
            'message' => "Hello beby"
        ]);
        Message::create([
            'chat_id' => '1',
            'message' => "Hello beby"
        ]);
        Message::create([
            'chat_id' => '1',
            'message' => "Hello beby"
        ]);
        Message::create([
            'chat_id' => '1',
            'message' => "Hello beby"
        ]);
        Queue::create([
            'no' => "546546",
            'user_id' => 1,
            'sex' => 'm',
            'status' => true

        ]);
        Queue::create([
            'no' => "546546",
            'user_id' => 2,
            'sex' => 'z',
            'status' => true
        ]);
        Queue::create([
            'no' => "546546",
            'user_id' => 3,
            'sex' => 'm',
            'status' => true

        ]);
    }
}
