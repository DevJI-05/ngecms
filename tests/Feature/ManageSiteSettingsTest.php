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

test('phone fields reject letters', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm([$field => 'abc'])
        ->call('save')
        ->assertHasFormErrors([$field]);
})->with(['phone', 'emergency_phone', 'pic1_phone', 'pic2_phone']);

test('phone fields reject numbers shorter than 8 digits', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm([$field => '+62'])
        ->call('save')
        ->assertHasFormErrors([$field]);
})->with(['phone', 'emergency_phone', 'pic1_phone', 'pic2_phone']);

test('whatsapp number rejects letters', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['whatsapp_number' => 'abc'])
        ->call('save')
        ->assertHasFormErrors(['whatsapp_number']);
});

test('whatsapp number rejects 08-prefixed local format', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['whatsapp_number' => '081234567890'])
        ->call('save')
        ->assertHasFormErrors(['whatsapp_number']);
});

test('whatsapp number rejects short +62 format', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['whatsapp_number' => '+62'])
        ->call('save')
        ->assertHasFormErrors(['whatsapp_number']);
});

test('whatsapp number accepts valid 62-prefixed format', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['whatsapp_number' => '6281234567890'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(SiteSetting::current()->whatsapp_number)->toBe('6281234567890');
});

test('stat fields reject non-numeric text', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm([$field => 'abc'])
        ->call('save')
        ->assertHasFormErrors([$field]);
})->with([
    'stat_projects_completed',
    'stat_pipeline_km',
    'stat_years_experience',
    'stat_provinces',
    'stat_employees',
    'stat_active_clients',
]);

test('stat fields reject decimal values', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm([$field => '15.5'])
        ->call('save')
        ->assertHasFormErrors([$field]);
})->with([
    'stat_projects_completed',
    'stat_pipeline_km',
    'stat_years_experience',
    'stat_provinces',
    'stat_employees',
    'stat_active_clients',
]);

test('stat fields reject negative values', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm([$field => '-3'])
        ->call('save')
        ->assertHasFormErrors([$field]);
})->with([
    'stat_projects_completed',
    'stat_pipeline_km',
    'stat_years_experience',
    'stat_provinces',
    'stat_employees',
    'stat_active_clients',
]);

test('established year rejects decimal values', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['established_year' => '2.5'])
        ->call('save')
        ->assertHasFormErrors(['established_year']);
});

test('established year rejects a year in the future', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['established_year' => (string) (now()->year + 1)])
        ->call('save')
        ->assertHasFormErrors(['established_year']);
});

test('established year accepts a valid past year', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['established_year' => '2008'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(SiteSetting::current()->established_year)->toBe(2008);
});

test('email fields reject an address without a tld', function (string $field) {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm([$field => 'a@b'])
        ->call('save')
        ->assertHasFormErrors([$field]);
})->with(['email_info', 'email_project']);

test('email fields accept a valid address', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['email_info' => 'contact@nusantaragas.co.id'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(SiteSetting::current()->email_info)->toBe('contact@nusantaragas.co.id');
});

test('stat fields accept a positive integer', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ManageSiteSettings::class)
        ->fillForm(['stat_provinces' => '20'])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(SiteSetting::current()->stat_provinces)->toBe(20);
});
