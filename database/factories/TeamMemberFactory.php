<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamMember>
 */
class TeamMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'role' => $this->faker->jobTitle(),
            'level' => $this->faker->randomElement(['komisaris', 'direksi', 'manajer', 'staff']),
            'initials' => $this->faker->lexify('??'),
            'avatar_bg' => '#ffffff',
            'avatar_color' => '#000000',
            'sort_order' => 0,
        ];
    }
}
