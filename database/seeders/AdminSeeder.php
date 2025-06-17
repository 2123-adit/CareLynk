<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@carelynk.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@carelynk.com',
                'password' => Hash::make('admin123'),
                'balance' => 0,
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}