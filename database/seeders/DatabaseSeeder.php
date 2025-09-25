<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        ];
        Setting::insert($settings);
    }
}
