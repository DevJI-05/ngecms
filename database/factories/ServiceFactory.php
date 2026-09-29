<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cat' => $this->faker->word(),
            'icon' => 'ti ti-flame',
            'icon_bg' => '#FEE2E2',
            'icon_color' => '#DC2626',
            'name' => $this->faker->unique()->words(2, true),
            'tagline' => $this->faker->sentence(),
            'badge_bg' => '#DBEAFE',
            'badge_color' => '#1D4ED8',
            'description' => $this->faker->paragraph(),
            'accent' => '#2563EB',
            'foot_note' => $this->faker->sentence(),
            'prompt' => $this->faker->sentence(),
            'sort_order' => 0,
        ];
    }
}
