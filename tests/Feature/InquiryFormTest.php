<?php

use App\Filament\Resources\Inquiries\Pages\CreateInquiry;
use App\Filament\Resources\Inquiries\Pages\EditInquiry;
use App\Filament\Resources\Inquiries\Pages\ListInquiries;
use App\Models\Inquiry;
use App\Models\Service;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Filament\Forms\Components\Select;
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

    Service::factory()->create(['name' => 'Gas Pipeline']);

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

test('service dropdown lists active services with lainnya as the last option', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $first = Service::factory()->create(['name' => 'Gas Pipeline', 'sort_order' => 1]);
    $second = Service::factory()->create(['name' => 'CNG Filling Station', 'sort_order' => 2]);

    Livewire::test(CreateInquiry::class)
        ->assertFormFieldExists('layanan', function (Select $field) use ($first, $second): bool {
            return array_keys($field->getOptions()) === [$first->name, $second->name, 'Lainnya'];
        });
});

test('service detail is only required when lainnya is selected', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    Service::factory()->create(['name' => 'Gas Pipeline']);

    Livewire::test(CreateInquiry::class)
        ->fillForm(validInquiryData(['layanan' => 'Gas Pipeline']))
        ->call('create')
        ->assertHasNoFormErrors();

    Livewire::test(CreateInquiry::class)
        ->fillForm(validInquiryData(['layanan' => 'Lainnya', 'layanan_detail' => null, 'email' => 'lain@example.com']))
        ->call('create')
        ->assertHasFormErrors(['layanan_detail']);

    Livewire::test(CreateInquiry::class)
        ->fillForm(validInquiryData(['layanan' => 'Lainnya', 'layanan_detail' => 'Konsultasi teknis', 'email' => 'lain2@example.com']))
        ->call('create')
        ->assertHasNoFormErrors();
});

test('legacy free-text service value still shows on the read-only edit form', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $this->actingAs($admin);

    $inquiry = Inquiry::create(validInquiryData(['layanan' => 'Layanan Lama Sudah Dihapus']));

    Livewire::test(EditInquiry::class, ['record' => $inquiry->getRouteKey()])
        ->assertSchemaStateSet(['layanan' => 'Layanan Lama Sudah Dihapus']);
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
