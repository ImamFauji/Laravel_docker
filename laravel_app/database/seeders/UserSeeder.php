<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Imam F',
            'email' => 'imam123@gmail.com',
            'password' => Hash::make('admin123'), // sudah di-hash
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
