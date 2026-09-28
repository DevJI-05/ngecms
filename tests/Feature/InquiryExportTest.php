<?php

use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Models\Inquiry;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use OpenSpout\Reader\XLSX\Reader;

function makeInquiry(array $overrides = []): Inquiry
{
    $inquiry = Inquiry::create(array_merge([
        'nama' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'layanan' => 'Gas Pipeline',
        'pesan' => 'Mohon informasi lebih lanjut mengenai layanan.',
        'status' => 'baru',
    ], $overrides));

    if (array_key_exists('created_at', $overrides)) {
        $inquiry->forceFill(['created_at' => $overrides['created_at']])->save();
    }

    return $inquiry;
}

function readXlsxRows(string $binary): array
{
    $tempFile = tempnam(sys_get_temp_dir(), 'inquiries').'.xlsx';
    file_put_contents($tempFile, $binary);

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

    return $rows;
}

beforeEach(function () {
    Storage::fake('local');
});

test('exporting all inquiries processes every record and offers a download', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    makeInquiry(['nama' => 'Siti Aminah', 'email' => 'siti@example.com']);
    makeInquiry(['nama' => 'Budi Santoso', 'email' => 'budi@example.com']);

    $component = Livewire::test(ListInquiries::class)
        ->mountAction(TestAction::make('export')->table())
        ->fillForm(['scope' => 'all'])
        ->callMountedAction()
        ->assertHasNoFormErrors()
        ->call('pollInquiryExportProgress');

    expect($component->get('inquiryExportStatus'))->toBe('done');
    expect($component->get('inquiryExportProcessed'))->toBe(2);
    expect($component->get('inquiryExportTotal'))->toBe(2);

    $exportId = $component->get('inquiryExportId');

    $response = $this->get(route('admin.inquiries.export.download', $exportId));
    $response->assertOk()
        ->assertHeader('Content-Type', 'application/vnd.ms-excel')
        ->assertDownload();

    $rows = readXlsxRows($response->streamedContent());

    expect($rows[0])->toContain('Name', 'Email');
    expect(collect($rows)->flatten())->toContain('Siti Aminah', 'Budi Santoso');
});

test('exporting a date range only includes inquiries within that range', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    makeInquiry(['nama' => 'Di Dalam Rentang', 'email' => 'in-range@example.com', 'created_at' => '2026-01-15 10:00:00']);
    makeInquiry(['nama' => 'Di Luar Rentang', 'email' => 'out-of-range@example.com', 'created_at' => '2026-03-01 10:00:00']);

    $component = Livewire::test(ListInquiries::class)
        ->mountAction(TestAction::make('export')->table())
        ->fillForm([
            'scope' => 'range',
            'dateFrom' => '2026-01-01',
            'dateUntil' => '2026-01-31',
        ])
        ->callMountedAction()
        ->assertHasNoFormErrors()
        ->call('pollInquiryExportProgress');

    expect($component->get('inquiryExportStatus'))->toBe('done');
    expect($component->get('inquiryExportProcessed'))->toBe(1);

    $exportId = $component->get('inquiryExportId');

    $response = $this->get(route('admin.inquiries.export.download', $exportId));
    $rows = readXlsxRows($response->streamedContent());

    $flattened = collect($rows)->flatten();
    expect($flattened)->toContain('Di Dalam Rentang')
        ->and($flattened)->not->toContain('Di Luar Rentang');
});

test('date range export requires both dates', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Livewire::test(ListInquiries::class)
        ->mountAction(TestAction::make('export')->table())
        ->fillForm(['scope' => 'range'])
        ->callMountedAction()
        ->assertHasFormErrors(['dateFrom', 'dateUntil']);
});

test('guests cannot download an inquiry export', function () {
    $this->get(route('admin.inquiries.export.download', 'some-export-id'))
        ->assertRedirect('/admin/login');
});

test('a missing or expired export download returns 404', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $this->get(route('admin.inquiries.export.download', 'does-not-exist'))
        ->assertNotFound();
});
