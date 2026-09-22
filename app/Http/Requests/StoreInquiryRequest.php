<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('telepon')) {
            $this->merge([
                'telepon' => preg_replace('/[\s-]+/', '', (string) $this->input('telepon')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,filter', 'max:255'],
            'telepon' => ['required', 'string', 'max:14', 'regex:/^(\+62|62|0)8[0-9]{7,11}$/'],
            'perusahaan' => ['nullable', 'string', 'max:255'],
            'layanan' => ['required', 'string', 'max:255'],
            'estimasi' => ['nullable', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'pesan' => ['required', 'string'],
            'sumber' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'telepon.regex' => 'Nomor telepon/WhatsApp harus berupa nomor Indonesia yang valid, contoh: 0812xxxxxxx atau +62812xxxxxxx.',
            'telepon.max' => 'Nomor telepon/WhatsApp maksimal 14 digit.',
        ];
    }
}
