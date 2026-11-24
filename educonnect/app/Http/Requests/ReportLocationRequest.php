<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'min:10', 'max:1500'],
            'reporter_name' => ['nullable', 'string', 'max:120'],
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
            'title.required' => 'Jenis atau ringkasan masalah wajib diisi.',
            'title.max' => 'Ringkasan masalah maksimal 150 karakter.',
            'description.required' => 'Detail laporan masalah wajib diisi.',
            'description.min' => 'Mohon jelaskan masalah minimal 10 karakter agar tim kami dapat menindaklanjuti.',
            'description.max' => 'Detail laporan maksimal 1500 karakter.',
        ];
    }
}
