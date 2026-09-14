<?php

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Models\Inquiry;
use App\Models\User;
use Livewire\Livewire;

function validInquiryData(array $overrides = []): array
{
    return array_merge([
        'nama' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'layanan' => 'Gas Pipeline',
        'pesan' => 'Mohon informasi lebih lanjut mengenai layanan.',
        'status' => 'baru',
    ], $overrides);
}

test('admin can manually create an inquiry with all fields enabled', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(CreateInquiry::class)
        ->assertFormFieldIsEnabled('nama')
        ->assertFormFieldIsEnabled('email')
        ->assertFormFieldIsEnabled('layanan')
        ->assertFormFieldIsEnabled('pesan')
        ->fillForm(validInquiryData())
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Inquiry::query()->where('email', 'budi@example.com')->first())
        ->nama->toBe('Budi Santoso');
});

test('inquiry submitted from the public site remains read-only when edited', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $inquiry = Inquiry::create(validInquiryData(['sumber' => 'Website']));

    Livewire::test(EditInquiry::class, ['record' => $inquiry->getRouteKey()])
        ->assertFormFieldIsDisabled('nama')
        ->assertFormFieldIsDisabled('email')
        ->assertFormFieldIsEnabled('status');
});
