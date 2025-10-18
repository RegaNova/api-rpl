<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'date_birth' => ['required', 'date'],
            'instagram' => ['required', 'string', 'max:255'],
            'words' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // max 2MB
            'generation_id' => ['required', 'uuid', 'exists:generations,id'],
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'name' => ['sometimes', 'string', 'max:255'],
                'date_birth' => ['sometimes', 'date'],
                'instagram' => ['sometimes', 'string', 'max:255'],
                'words' => ['sometimes', 'string'],
                'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'generation_id' => ['sometimes', 'uuid', 'exists:generations,id'],
            ];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // name
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',

            // date_birth
            'date_birth.required' => 'Tanggal lahir harus diisi.',
            'date_birth.date' => 'Format tanggal lahir tidak valid.',

            // instagram
            'instagram.required' => 'Username Instagram harus diisi.',
            'instagram.string' => 'Username Instagram harus berupa teks.',
            'instagram.max' => 'Username Instagram maksimal 255 karakter.',

            // words
            'words.required' => 'Kata-kata harus diisi.',
            'words.string' => 'Kata-kata harus berupa teks.',

            // image
            'image.required' => 'Gambar harus diisi.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Gambar harus berupa file dengan format: jpeg, png, jpg, gif.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',

            // generation_id
            'generation_id.required' => 'ID generasi harus diisi.',
            'generation_id.uuid' => 'ID generasi harus berupa UUID yang valid.',
            'generation_id.exists' => 'ID generasi tidak ditemukan di tabel generasi.',
        ];
    }
}
