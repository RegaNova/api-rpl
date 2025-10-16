<?php

namespace App\Http\Requests\Position;

use Illuminate\Foundation\Http\FormRequest;

class PositionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255']
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'name' => ['sometimes', 'string', 'max:255']
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus di isi',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter'
        ];
    }
}
