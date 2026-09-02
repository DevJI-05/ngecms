<?php

use App\Filament\Resources\CompanyValues\Pages\CreateCompanyValue;
use App\Models\CompanyValue;
use App\Models\User;
use App\Support\CompanyValueIcons;
use Livewire\Livewire;

test('company value icon options only contain icons available in the tabler icon font', function () {
    expect(CompanyValueIcons::options())->not->toBeEmpty();

    foreach (array_keys(CompanyValueIcons::options()) as $icon) {
        expect($icon)->toStartWith('ti-');
    }
});

test('admin can create a company value by picking an icon from the picker', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $icon = array_key_first(CompanyValueIcons::options());

    Livewire::test(CreateCompanyValue::class)
        ->fillForm([
            'icon' => $icon,
            'name' => 'Nilai Uji Coba',
            'description' => 'Deskripsi uji coba',
            'accent' => '#000000',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(CompanyValue::query()->where('name', 'Nilai Uji Coba')->first())
        ->icon->toBe($icon);
});

test('company value creation rejects an icon that is not in the curated picker list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateCompanyValue::class)
        ->fillForm([
            'icon' => 'test',
            'name' => 'Nilai Uji Coba',
            'description' => 'Deskripsi uji coba',
            'accent' => '#000000',
        ])
        ->call('create')
        ->assertHasFormErrors(['icon']);
});
