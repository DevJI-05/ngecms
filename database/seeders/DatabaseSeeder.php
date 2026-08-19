<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@nusantaragas.co.id'],
            [
                'name' => 'Admin Nusantara Gas Energy',
                'password' => 'password',
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );

        $this->call([
            PortfolioProjectSeeder::class,
            ServiceSeeder::class,
            MilestoneSeeder::class,
            CertificationSeeder::class,
            TeamMemberSeeder::class,
            CompanyValueSeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}
