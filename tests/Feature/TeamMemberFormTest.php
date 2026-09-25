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

test('a team member with no parent is level 0', function () {
    $member = TeamMember::factory()->create(['parent_id' => null]);

    expect($member->level)->toBe(0);
});

test('a team member auto-derives its level as one below its parent', function () {
    $root = TeamMember::factory()->create(['parent_id' => null]);
    $child = TeamMember::factory()->create(['parent_id' => $root->id]);
    $grandchild = TeamMember::factory()->create(['parent_id' => $child->id]);

    expect($root->level)->toBe(0)
        ->and($child->level)->toBe(1)
        ->and($grandchild->level)->toBe(2);
});

test('re-parenting a team member cascades the new level down to its descendants', function () {
    $rootA = TeamMember::factory()->create(['parent_id' => null]);
    $rootB = TeamMember::factory()->create(['parent_id' => null]);
    $child = TeamMember::factory()->create(['parent_id' => $rootA->id]);
    $grandchild = TeamMember::factory()->create(['parent_id' => $child->id]);

    // Move rootA (and everything under it) to report to rootB instead.
    $rootA->update(['parent_id' => $rootB->id]);

    expect($rootA->fresh()->level)->toBe(1)
        ->and($child->fresh()->level)->toBe(2)
        ->and($grandchild->fresh()->level)->toBe(3);
});

test('admin can set who a team member reports to and the level updates automatically', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $director = TeamMember::factory()->create(['parent_id' => null]);
    $member = TeamMember::factory()->create(['parent_id' => null]);

    Livewire::test(EditTeamMember::class, ['record' => $member->getRouteKey()])
        ->fillForm(['parent_id' => $director->id])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($member->fresh())
        ->parent_id->toBe($director->id)
        ->level->toBe(1);
});
