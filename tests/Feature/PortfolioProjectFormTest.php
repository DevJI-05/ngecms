<?php

use App\Filament\Resources\PortfolioProjects\Pages\CreatePortfolioProject;
use App\Models\PortfolioProject;
use App\Models\User;
use App\Support\ServiceIconOptions;
use Livewire\Livewire;

test('portfolio project creation accepts valid hex colors', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $icon = array_key_first(ServiceIconOptions::options());

    Livewire::test(CreatePortfolioProject::class)
        ->fillForm([
            'name' => 'Proyek Uji Coba',
            'cat' => 'pipeline',
            'status' => 'done',
            'year' => 2024,
            'scale' => 3,
            'location' => 'Jakarta',
            'client' => 'PT Uji Coba',
            'icon' => $icon,
            'color' => '#ffffff',
            'bg_light' => '#000000',
            'accent_text' => '#abc',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(PortfolioProject::query()->where('name', 'Proyek Uji Coba')->first())
        ->color->toBe('#ffffff');
});

test('portfolio project creation rejects an invalid hex color', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $icon = array_key_first(ServiceIconOptions::options());

    Livewire::test(CreatePortfolioProject::class)
        ->fillForm([
            'name' => 'Proyek Uji Coba',
            'cat' => 'pipeline',
            'status' => 'done',
            'year' => 2024,
            'scale' => 3,
            'location' => 'Jakarta',
            'client' => 'PT Uji Coba',
            'icon' => $icon,
            'color' => '#ffffff',
            'bg_light' => '#000000',
            'accent_text' => '#000000',
            $field => '#GGGGGG',
        ])
        ->call('create')
        ->assertHasFormErrors([$field]);
})->with(['color', 'bg_light', 'accent_text']);
