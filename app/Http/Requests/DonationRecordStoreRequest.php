<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class DonationRecordStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'donor_name'     => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20',
            'tujuan'         => 'required|string|max:255',
            'payment_method' => 'required|in:bank_transfer,cash,qris,other',
            'bank_account_id' => 'required_if:payment_method,bank_transfer|nullable|exists:bank_accounts,id',
            'amount'         => 'required|numeric|min:1000',
            'payment_proof'  => 'required_if:payment_method,bank_transfer|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'donor_name.required'              => 'Nama donatur wajib diisi.',
            'phone_number.required'            => 'Nomor telepon wajib diisi.',
            'phone_number.max'                 => 'Nomor telepon maksimal 20 karakter.',
            'tujuan.required'                  => 'Tujuan donasi wajib diisi.',
            'payment_method.required'          => 'Metode pembayaran wajib diisi.',
            'payment_method.in'                => 'Metode pembayaran tidak valid.',
            'bank_account_id.required_if'      => 'Rekening bank wajib dipilih untuk transfer bank.',
            'bank_account_id.exists'           => 'Rekening bank tidak ditemukan.',
            'amount.required'                  => 'Jumlah donasi wajib diisi.',
            'amount.numeric'                   => 'Jumlah donasi harus berupa angka.',
            'amount.min'                       => 'Jumlah donasi minimal Rp 1.000.',
            'payment_proof.required_if'        => 'Bukti pembayaran wajib diupload untuk transfer bank.',
            'payment_proof.image'              => 'Bukti pembayaran harus berupa gambar.',
            'payment_proof.mimes'              => 'Format bukti pembayaran harus jpg, jpeg, atau png.',
            'payment_proof.max'                => 'Ukuran bukti pembayaran maksimal 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'data'    => null,
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
