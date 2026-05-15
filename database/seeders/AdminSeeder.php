<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // بنحدث اليوزر اللي إيميله admin@admin.com ونحطله username
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'username' => 'admin',
                'name' => 'Admin',
                'password' => Hash::make('11223344'),
            ]
        );
    }
}
