<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberSeeder extends Seeder
{
    public function run()
    {
        DB::table('members')->insert([
            [
                'nama' => 'Richard Steven',
                'email' => 'richardsteven@gmail.com',
                'tanggal_lahir' => '2000-01-01',
                'no_hp' => '081234567890',
                'password' => Hash::make('steven123'),
                'token' => null,
                'token_expires_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Ansell Bonang',
                'email' => 'ansellbonang@gmail.com',
                'tanggal_lahir' => '1995-05-15',
                'no_hp' => '089876543210',
                'password' => Hash::make('ansell123'),
                'token' => null,
                'token_expires_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
