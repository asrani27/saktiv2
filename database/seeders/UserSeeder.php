<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        DB::table('users')->insert([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@saktiv.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Regular User
        DB::table('users')->insert([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@saktiv.com',
            'email_verified_at' => now(),
            'password' => Hash::make('user123'),
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}