<?php

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
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

test('inquiries table shows an export csv action linking to the export route', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ListInquiries::class)
        ->assertSeeHtml(route('admin.inquiries.export'));
});

test('admin can download the inquiries export as csv', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Inquiry::create(validInquiryData(['nama' => 'Siti Aminah', 'email' => 'siti@example.com']));

    $response = $this->get(route('admin.inquiries.export'));

    $response->assertOk()
        ->assertHeader('Content-Type', 'text/csv; charset=UTF-8')
        ->assertDownload();

    expect($response->streamedContent())
        ->toContain('Siti Aminah')
        ->toContain('siti@example.com');
});

test('guests cannot download the inquiries export', function () {
    $this->get(route('admin.inquiries.export'))
        ->assertRedirect('/admin/login');
});
