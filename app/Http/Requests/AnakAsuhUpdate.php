<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AnakAsuhUpdate extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => 'sometimes|string|max:255',
            'age'             => 'sometimes|integer|min:0|max:99',
            'tanggal_lahir'   => 'sometimes|date',
            'tempat_lahir'    => 'sometimes|string|max:255',
            'gender'          => 'sometimes|in:Laki-laki,Perempuan',
            'education'       => 'sometimes|in:Tidak Sekolah,TK,SD,SMP,SMA,Kuliah',
            'education_level' => 'sometimes|string|max:255',
            'status'          => 'sometimes|in:Dhuafa,Yatim,Piatu',
            'description'     => 'nullable|string',
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max'                 => 'Nama tidak boleh lebih dari 255 karakter.',
            'age.integer'              => 'Umur harus berupa angka.',
            'age.min'                  => 'Umur tidak boleh kurang dari 0.',
            'age.max'                  => 'Umur tidak boleh lebih dari 99.',
            'tanggal_lahir.date'       => 'Format tanggal lahir tidak valid.',
            'tempat_lahir.max'         => 'Tempat lahir tidak boleh lebih dari 255 karakter.',
            'gender.in'                => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'education.in'             => 'Pendidikan tidak valid. Pilih: Tidak Sekolah, TK, SD, SMP, SMA, atau Kuliah.',
            'education_level.max'      => 'Jenjang pendidikan tidak boleh lebih dari 255 karakter.',
            'status.in'                => 'Status tidak valid. Pilih: Dhuafa, Yatim, atau Piatu.',
            'photo.image'              => 'File foto harus berupa gambar.',
            'photo.mimes'              => 'Format foto harus jpg, jpeg, atau png.',
            'photo.max'                => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
