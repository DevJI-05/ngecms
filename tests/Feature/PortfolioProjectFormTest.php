<?php

use App\Filament\Resources\PortfolioProjects\Pages\CreatePortfolioProject;
use App\Models\PortfolioProject;
use App\Models\User;
use App\Support\ServiceIconOptions;
use Livewire\Livewire;

function validPortfolioProjectData(array $overrides = []): array
{
    return array_merge([
        'name' => 'Proyek Uji Coba',
        'cat' => 'pipeline',
        'status' => 'done',
        'year' => 2024,
        'scale' => 3,
        'location' => 'Jakarta',
        'client' => 'PT Uji Coba',
        'icon' => array_key_first(ServiceIconOptions::options()),
        'color' => '#ffffff',
        'bg_light' => '#000000',
        'accent_text' => '#abc',
    ], $overrides);
}

test('portfolio project creation accepts valid hex colors', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreatePortfolioProject::class)
        ->fillForm(validPortfolioProjectData())
        ->call('create')
        ->assertHasNoFormErrors();

    expect(PortfolioProject::query()->where('name', 'Proyek Uji Coba')->first())
        ->color->toBe('#ffffff');
});

test('portfolio project creation rejects an invalid hex color', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreatePortfolioProject::class)
        ->fillForm(validPortfolioProjectData([$field => '#GGGGGG']))
        ->call('create')
        ->assertHasFormErrors([$field]);
})->with(['color', 'bg_light', 'accent_text']);

test('portfolio project year rejects decimal values', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreatePortfolioProject::class)
        ->fillForm(validPortfolioProjectData(['year' => '2.5']))
        ->call('create')
        ->assertHasFormErrors(['year']);
});

test('portfolio project year rejects a year in the future', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreatePortfolioProject::class)
        ->fillForm(validPortfolioProjectData(['year' => (string) (now()->year + 1)]))
        ->call('create')
        ->assertHasFormErrors(['year']);
});

test('portfolio project scale rejects decimal values', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreatePortfolioProject::class)
        ->fillForm(validPortfolioProjectData(['scale' => '3.5']))
        ->call('create')
        ->assertHasFormErrors(['scale']);
});
