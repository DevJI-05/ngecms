<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@nusantaragas.co.id'],
            [
                'name' => 'Admin N.G.E',
                'password' => 'qweasdzxcedcwsxqaz',
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
