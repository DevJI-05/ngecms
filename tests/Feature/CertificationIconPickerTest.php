<?php

use App\Filament\Resources\Certifications\Pages\CreateCertification;
use App\Models\Certification;
use App\Models\User;
use App\Support\ServiceIconOptions;
use Livewire\Livewire;

test('admin can create a certification by picking an icon from the picker', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $icon = array_key_first(ServiceIconOptions::options());

    Livewire::test(CreateCertification::class)
        ->fillForm([
            'name' => 'Sertifikat Uji Coba',
            'issuer' => 'Badan Uji Coba',
            'valid_text' => 'Valid through 2030',
            'icon' => $icon,
            'icon_bg' => '#ffffff',
            'icon_color' => '#000000',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Certification::query()->where('name', 'Sertifikat Uji Coba')->first())
        ->icon->toBe($icon);
});

test('certification creation rejects an icon that is not in the curated picker list', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateCertification::class)
        ->fillForm([
            'name' => 'Sertifikat Uji Coba',
            'issuer' => 'Badan Uji Coba',
            'valid_text' => 'Valid through 2030',
            'icon' => 'test',
            'icon_bg' => '#ffffff',
            'icon_color' => '#000000',
        ])
        ->call('create')
        ->assertHasFormErrors(['icon']);
});
