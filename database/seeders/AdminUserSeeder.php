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
            ['email' => env('ADMIN_EMAIL', 'admin@nusantaragas.co.id')],
            [
                'name' => env('ADMIN_NAME', 'Admin Nusantara Gas Energy'),
                'password' => env('ADMIN_PASSWORD', 'password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
