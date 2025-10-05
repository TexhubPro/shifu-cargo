<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Setting;
use App\Models\Notification;
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
        User::create([
            'name' => "Shodmehr",
            'code' => "0002",
            'phone' => '46546546',
            'password' => Hash::make('005335051'),
            'role' => 'customer'
        ]);
        User::create([
            'name' => "Shodmehr",
            'code' => "0003",
            'phone' => '4567567',
            'password' => Hash::make('005335051'),
            'role' => 'customer'
        ]);
    }
}
