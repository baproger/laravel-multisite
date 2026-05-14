<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@company.kz'],
            [
                'name'      => 'Администратор',
                'email'     => 'admin@company.kz',
                'password'  => Hash::make('Admin@12345!'),
                'role'      => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin created: admin@company.kz / Admin@12345!');
    }
}
