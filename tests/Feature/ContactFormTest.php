<?php

use App\Models\Inquiry;

function validContactData(array $overrides = []): array
{
    return array_merge([
        'nama' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'telepon' => '081298765432',
        'layanan' => 'Gas Pipeline Construction',
        'pesan' => 'Mohon informasi lebih lanjut mengenai layanan.',
    ], $overrides);
}

test('submitting the public contact form with missing required fields returns validation errors', function () {
    $response = $this->from('/contact')->post('/contact', validContactData(['nama' => '']));

    $response->assertRedirect('/contact');
    $response->assertSessionHasErrors('nama');

    expect(Inquiry::query()->count())->toBe(0);
});

test('submitting the public contact form without a phone number returns a validation error', function () {
    $response = $this->from('/contact')->post('/contact', validContactData(['telepon' => '']));

    $response->assertSessionHasErrors('telepon');
    expect(Inquiry::query()->count())->toBe(0);
});

test('submitting the public contact form with an invalid phone number returns a validation error', function () {
    $response = $this->from('/contact')->post('/contact', validContactData(['telepon' => 'asal-asalan']));

    $response->assertSessionHasErrors('telepon');
    expect(Inquiry::query()->count())->toBe(0);
});

test('submitting the public contact form with a phone number longer than 14 digits returns a validation error', function () {
    $response = $this->from('/contact')->post('/contact', validContactData(['telepon' => '+62812987654321']));

    $response->assertSessionHasErrors('telepon');
    expect(Inquiry::query()->count())->toBe(0);
});

test('submitting the public contact form with an invalid email returns a validation error', function () {
    $response = $this->from('/contact')->post('/contact', validContactData(['email' => 'not-an-email']));

    $response->assertSessionHasErrors('email');
    expect(Inquiry::query()->count())->toBe(0);
});

test('submitting the public contact form with valid data stores the inquiry and flashes a success confirmation and toast', function () {
    $response = $this->post('/contact', validContactData());

    $response->assertRedirect();
    $response->assertSessionHas('inertia.flash_data');

    $inquiry = Inquiry::query()->where('email', 'budi@example.com')->first();
    expect($inquiry)->not->toBeNull();
    expect($inquiry->telepon)->toBe('081298765432');

    $flash = session('inertia.flash_data');
    expect($flash['inquirySubmitted']['nama'])->toBe('Budi Santoso');
    expect($flash['inquirySubmitted']['ref'])->toContain((string) $inquiry->id);
    expect($flash['toast']['type'])->toBe('success');
});

test('submitting the public contact form normalizes a phone number with spaces and dashes', function () {
    $this->post('/contact', validContactData(['telepon' => '+62 812-9876-5432']));

    $inquiry = Inquiry::query()->where('email', 'budi@example.com')->first();
    expect($inquiry->telepon)->toBe('+6281298765432');
});
