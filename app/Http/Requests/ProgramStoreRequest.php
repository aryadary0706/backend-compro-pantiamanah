<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProgramStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|image|mimes:jpg,jpeg,png|max:51200',
            'date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'time' => 'nullable|date_format:H:i',
        ];
    }

    public function messages(): array
    {
        return [
            'images.max' => 'File gambar kebesaran',
        ];
    }
}
