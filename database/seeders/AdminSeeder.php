<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@dfcases.com'],
            [
                'name'     => 'Admin',
                'role'     => 'admin',
                'password' => Hash::make('df2024admin'),
            ]
        );
    }
}
