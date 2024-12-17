<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Nick Down',
            'email' => 'nick@nickdown.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
} 