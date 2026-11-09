<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@sipala.com'],
            [
                'nama' => 'DEVMP',
                'password' => Hash::make('devmp123'),
                'role' => 'super_admin',
            ]
        );

        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@sipala.com'],
            [
                'nama' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
