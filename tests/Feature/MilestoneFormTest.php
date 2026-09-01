<?php

use App\Filament\Resources\Milestones\Pages\CreateMilestone;
use App\Models\Milestone;
use App\Models\User;
use Livewire\Livewire;

function validMilestoneData(array $overrides = []): array
{
    return array_merge([
        'year_label' => '2008 — Didirikan',
        'year' => 2008,
        'name' => 'Perusahaan Didirikan',
        'description' => 'Deskripsi uji coba',
        'badge' => 'Milestone',
        'dot_color' => '#ffffff',
        'badge_bg' => '#000000',
        'badge_color' => '#000000',
    ], $overrides);
}

test('milestone creation accepts valid hex colors', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateMilestone::class)
        ->fillForm(validMilestoneData())
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Milestone::query()->where('name', 'Perusahaan Didirikan')->first())
        ->dot_color->toBe('#ffffff');
});

test('milestone creation rejects an invalid hex color', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateMilestone::class)
        ->fillForm(validMilestoneData([$field => '#GGGGGG']))
        ->call('create')
        ->assertHasFormErrors([$field]);
})->with(['dot_color', 'badge_bg', 'badge_color']);

test('milestone year rejects decimal values', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateMilestone::class)
        ->fillForm(validMilestoneData(['year' => '2.5']))
        ->call('create')
        ->assertHasFormErrors(['year']);
});

test('milestone year rejects a year in the future', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateMilestone::class)
        ->fillForm(validMilestoneData(['year' => (string) (now()->year + 1)]))
        ->call('create')
        ->assertHasFormErrors(['year']);
});
