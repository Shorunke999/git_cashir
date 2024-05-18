<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PlatformStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'shorunke olamilekan mathew',
            'email' => 'shorunke99@gmail.com',
            'userType' => 0,
            'password' => Hash::make('12345678')
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'userType' => 1,
            'password' => Hash::make('12345678')
        ]);
        PlatformStatus::create([
            'platform_name' => 'paystack',
            'status' => 1
        ]);
        PlatformStatus::create([
            'platform_name' => 'monny',
            'status' => 1
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
