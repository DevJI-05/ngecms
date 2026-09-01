<?php

use App\Filament\Resources\Services\Pages\CreateService;
use App\Models\Service;
use App\Models\User;
use App\Support\ServiceIconOptions;
use Livewire\Livewire;

test('service icon options only contain icons available in the tabler icon font', function () {
    expect(ServiceIconOptions::options())->not->toBeEmpty();

    foreach (array_keys(ServiceIconOptions::options()) as $icon) {
        expect($icon)->toStartWith('ti-');
    }
});

test('admin can create a service by picking an icon from the picker', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $icon = array_key_first(ServiceIconOptions::options());

    Livewire::test(CreateService::class)
        ->fillForm([
            'name' => 'Layanan Uji Coba',
            'tagline' => 'Tagline uji coba',
            'cat' => 'pipeline',
            'icon' => $icon,
            'description' => 'Deskripsi uji coba',
            'foot_note' => 'Estimasi proyek: 1 bulan',
            'prompt' => 'Prompt uji coba',
            'icon_bg' => '#ffffff',
            'icon_color' => '#000000',
            'accent' => '#000000',
            'badge_bg' => '#ffffff',
            'badge_color' => '#000000',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Service::query()->where('name', 'Layanan Uji Coba')->first())
        ->icon->toBe($icon);
});

test('service creation rejects an invalid hex color', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $icon = array_key_first(ServiceIconOptions::options());

    Livewire::test(CreateService::class)
        ->fillForm([
            'name' => 'Layanan Uji Coba',
            'tagline' => 'Tagline uji coba',
            'cat' => 'pipeline',
            'icon' => $icon,
            'description' => 'Deskripsi uji coba',
            'foot_note' => 'Estimasi proyek: 1 bulan',
            'prompt' => 'Prompt uji coba',
            'icon_bg' => '#GGGGGG',
            'icon_color' => '#000000',
            'accent' => '#000000',
            'badge_bg' => '#ffffff',
            'badge_color' => '#000000',
        ])
        ->call('create')
        ->assertHasFormErrors(['icon_bg']);
});

test('service creation rejects a decimal display order', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $icon = array_key_first(ServiceIconOptions::options());

    Livewire::test(CreateService::class)
        ->fillForm([
            'name' => 'Layanan Uji Coba',
            'tagline' => 'Tagline uji coba',
            'cat' => 'pipeline',
            'icon' => $icon,
            'description' => 'Deskripsi uji coba',
            'foot_note' => 'Estimasi proyek: 1 bulan',
            'prompt' => 'Prompt uji coba',
            'icon_bg' => '#ffffff',
            'icon_color' => '#000000',
            'accent' => '#000000',
            'badge_bg' => '#ffffff',
            'badge_color' => '#000000',
            'sort_order' => '2.5',
        ])
        ->call('create')
        ->assertHasFormErrors(['sort_order']);
});
