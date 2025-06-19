<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Manager',
                'email' => 'manager@manager.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Ganti dengan password yang aman
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Employee',
                'email' => 'employee@employee.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Ganti dengan password yang aman
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
