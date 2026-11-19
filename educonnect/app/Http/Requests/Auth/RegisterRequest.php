<?php

namespace App\Http\Requests\Auth;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation (normalize legacy 'siswa' alias if passed).
     */
    protected function prepareForValidation(): void
    {
        if ($this->input('role') === 'siswa') {
            $this->merge(['role' => UserRole::Pelajar->value]);
        }

        if ($this->filled('email')) {
            $this->merge(['email' => strtolower(trim((string) $this->input('email')))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        return [
            'role' => [
                'required',
                'string',
                Rule::in(UserRole::registrableValues()),
            ],
            'display_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'location' => ['required', 'string', 'max:120'],
            'institution' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get custom Indonesian validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'role.required' => 'Silakan pilih peran Anda di EduConnect.',
            'role.in' => 'Peran yang dipilih tidak valid atau tidak diizinkan untuk pendaftaran mandiri.',
            'display_name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar. Silakan masuk menggunakan akun Anda.',
            'location.required' => 'Kota atau lokasi domisili wajib diisi.',
            'institution.required' => 'Informasi sekolah, komunitas, atau nama tempat belajar wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];
    }
}
