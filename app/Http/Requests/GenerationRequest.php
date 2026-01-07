<?php

namespace App\Http\Requests;

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
            'name' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100|unique:generations,year',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'name' => 'sometimes|string|max:255',
                'year' => 'sometimes|integer|min:1900|max:' . date('Y'),
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama generasi wajib diisi.',
            'name.string' => 'Nama generasi harus berupa string.',
            'name.max' => 'Nama generasi tidak boleh lebih dari 255 karakter.',

            'year.required' => 'Tahun generasi wajib diisi.',
            'year.integer' => 'Tahun generasi harus berupa angka.',
            'year.min' => 'Tahun generasi tidak boleh kurang dari 1900.',
            'year.max' => 'Tahun generasi tidak boleh lebih dari tahun saat ini.',
            'year.unique' => 'Tahun generasi sudah ada dalam database.',
            
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, atau svg.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2048 kilobyte.',        
        ];
    }
}
