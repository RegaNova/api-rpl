<?php

namespace App\Http\Requests\Generation;

use Illuminate\Foundation\Http\FormRequest;

class GenerationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'name' => ['sometimes', 'string', 'max:255'],
                'year' => ['sometimes', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
                'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama angkatan wajib diisi.',
            'name.max' => 'Nama angkatan tidak boleh lebih dari 255 karakter.',

            'year.required' => 'Tahun wajib diisi.',
            'year.digits' => 'Tahun harus terdiri dari 4 digit.',
            'year.integer' => 'Tahun harus berupa angka.',
            'year.min' => 'Tahun minimal 1900.',
            'year.max' => 'Tahun tidak boleh melebihi tahun sekarang.',

            'image.required' => 'Gambar wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar hanya boleh JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
