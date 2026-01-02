<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // TAMBAHKAN VALIDASI BERIKUT:
            'divisi' => ['nullable', 'string', 'max:100'],
            'no_wa' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Kustomisasi nama atribut untuk pesan error (Bahasa Indonesia).
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Personel',
            'email' => 'Alamat Email',
            'divisi' => 'Sektor Unit / Divisi',
            'no_wa' => 'Nomor WhatsApp',
        ];
    }
}