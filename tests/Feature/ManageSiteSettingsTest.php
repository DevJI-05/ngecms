<?php

use App\Filament\Pages\ManageSiteSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Livewire\Livewire;

test('admin can render the site settings page', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->assertSuccessful();
});

test('admin can save site settings', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['company_name' => 'Updated Company Name'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(SiteSetting::current()->company_name)->toBe('Updated Company Name');
});
