<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        // Admin account
        User::create([
            'name' => 'CaffeArabica Admin',
            'email' => 'caffearabicaexample@gmail.com',
            'password' => Hash::make('@Admin001'),
            'role' => 'Admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Customer account
        User::create([
            'name' => 'CaffeArabica Customer',
            'email' => 'customer@caffearabica.com',
            'password' => Hash::make('Customer123!'),
            'role' => 'Customer',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kitchen account
        User::create([
            'name' => 'CaffeArabica Kitchen',
            'email' => 'kitchen@caffearabica.com',
            'password' => Hash::make('Kitchen123!'),
            'role' => 'Kitchen',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}