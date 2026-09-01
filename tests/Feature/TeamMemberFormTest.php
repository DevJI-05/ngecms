<?php

use App\Filament\Resources\TeamMembers\Pages\CreateTeamMember;
use App\Models\TeamMember;
use App\Models\User;
use Livewire\Livewire;

test('team member creation accepts valid hex colors', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateTeamMember::class)
        ->fillForm([
            'name' => 'Budi Santoso',
            'role' => 'Manajer',
            'level' => 'manajer',
            'initials' => 'BS',
            'avatar_bg' => '#ffffff',
            'avatar_color' => '#000000',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(TeamMember::query()->where('name', 'Budi Santoso')->first())
        ->avatar_bg->toBe('#ffffff');
});

test('team member creation rejects an invalid hex color', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateTeamMember::class)
        ->fillForm([
            'name' => 'Budi Santoso',
            'role' => 'Manajer',
            'level' => 'manajer',
            'initials' => 'BS',
            'avatar_bg' => '#ffffff',
            'avatar_color' => '#000000',
            $field => '#GGGGGG',
        ])
        ->call('create')
        ->assertHasFormErrors([$field]);
})->with(['avatar_bg', 'avatar_color']);
