<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProgramUpdateRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'images' => 'sometimes|image|mimes:jpg,jpeg,png|max:51200',
            'date' => 'sometimes|date',
            'location' => 'sometimes|string|max:255',
            'time' => 'sometimes|date_format:H:i',
        ];
    }

    public function messages(): array
    {
        return [
            'images.max' => 'File gambar kebesaran',
        ];
    }
}
