<?php

use App\Filament\Resources\TeamMembers\Pages\CreateTeamMember;
use App\Filament\Resources\TeamMembers\Pages\EditTeamMember;
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

test('team member cannot report to themselves', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $member = TeamMember::factory()->create();

    Livewire::test(EditTeamMember::class, ['record' => $member->getRouteKey()])
        ->fillForm(['parent_id' => $member->id])
        ->call('save')
        ->assertHasFormErrors(['parent_id']);
});

test('team member hierarchy rejects a circular reference', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $memberA = TeamMember::factory()->create();
    $memberB = TeamMember::factory()->create(['parent_id' => $memberA->id]);

    Livewire::test(EditTeamMember::class, ['record' => $memberA->getRouteKey()])
        ->fillForm(['parent_id' => $memberB->id])
        ->call('save')
        ->assertHasFormErrors(['parent_id']);
});

test('team member cannot report to a peer at the same level', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $peer = TeamMember::factory()->create(['level' => 'manajer']);
    $member = TeamMember::factory()->create(['level' => 'manajer']);

    Livewire::test(EditTeamMember::class, ['record' => $member->getRouteKey()])
        ->fillForm(['parent_id' => $peer->id])
        ->call('save')
        ->assertHasFormErrors(['parent_id']);
});

test('team member cannot report to someone at a lower level', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $subordinate = TeamMember::factory()->create(['level' => 'staff']);
    $member = TeamMember::factory()->create(['level' => 'manajer']);

    Livewire::test(EditTeamMember::class, ['record' => $member->getRouteKey()])
        ->fillForm(['parent_id' => $subordinate->id])
        ->call('save')
        ->assertHasFormErrors(['parent_id']);
});

test('team member can report to someone at a higher level', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $director = TeamMember::factory()->create(['level' => 'direksi']);
    $member = TeamMember::factory()->create(['level' => 'manajer']);

    Livewire::test(EditTeamMember::class, ['record' => $member->getRouteKey()])
        ->fillForm(['parent_id' => $director->id])
        ->call('save')
        ->assertHasNoFormErrors();
});
