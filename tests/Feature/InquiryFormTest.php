<?php

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Livewire\Livewire;
use OpenSpout\Reader\XLSX\Reader;

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

test('inquiries table shows an enabled export action', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ListInquiries::class)
        ->assertActionExists(TestAction::make('export')->table())
        ->assertActionEnabled(TestAction::make('export')->table());
});

test('admin can download the inquiries export as xlsx', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Inquiry::create(validInquiryData(['nama' => 'Siti Aminah', 'email' => 'siti@example.com']));

    $response = $this->get(route('admin.inquiries.export'));

    $response->assertOk()
        ->assertHeader('Content-Type', 'application/vnd.ms-excel')
        ->assertDownload();

    $tempFile = tempnam(sys_get_temp_dir(), 'inquiries').'.xlsx';
    file_put_contents($tempFile, $response->streamedContent());

    $reader = new Reader;
    $reader->open($tempFile);

    $rows = [];
    foreach ($reader->getSheetIterator() as $sheet) {
        foreach ($sheet->getRowIterator() as $row) {
            $rows[] = $row->toArray();
        }
    }
    $reader->close();
    unlink($tempFile);

    expect($rows[0])->toContain('Name', 'Email');
    expect($rows[1])->toContain('Siti Aminah', 'siti@example.com');
});

test('guests cannot download the inquiries export', function () {
    $this->get(route('admin.inquiries.export'))
        ->assertRedirect('/admin/login');
});
