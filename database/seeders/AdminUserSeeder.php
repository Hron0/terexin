<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@techcif.ru'],
            [
                'name' => 'Администратор',
                'email' => 'admin@techcif.ru',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create regular test user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'user@techcif.ru'],
            [
                'name' => 'Тестовый пользователь',
                'email' => 'user@techcif.ru',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}
