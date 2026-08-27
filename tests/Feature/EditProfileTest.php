<?php

use App\Models\User;
use Filament\Auth\Pages\EditProfile;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('admin can render the profile page', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(EditProfile::class)
        ->assertSuccessful();
});

test('admin can change their password', function () {
    $admin = User::factory()->create([
        'is_admin' => true,
        'password' => Hash::make('old-password'),
    ]);
    $this->actingAs($admin);

    Livewire::test(EditProfile::class)
        ->fillForm([
            'name' => $admin->name,
            'email' => $admin->email,
            'password' => 'new-secret-password',
            'passwordConfirmation' => 'new-secret-password',
            'currentPassword' => 'old-password',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect(Hash::check('new-secret-password', $admin->fresh()->password))->toBeTrue();
});
