<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Menampilkan data profile (Read)
     */
    public function index()
    {
        // Mengambil data pertama yang ditemukan di database
        $profile = Profile::first();

        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data profil belum dikonfigurasi.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $profile
        ]);
    }

    /**
     * Membuat atau Memperbarui data profile (Create/Update)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'email_information' => 'nullable|string',
            'phone_number' => 'required|string|max:20',
            'Whatsapp_number' => 'required|string',
            'contact_information' => 'nullable|string',
            'Operational_information' => 'nullable|string',
            'qris_file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'whatsapp_link' => 'nullable|string|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Ambil data pertama (Single Row Pattern)
        $profile = Profile::firstOrNew();

        // 3. Persiapkan data teks (kecuali file)
        $data = $request->except('qris_file');

        // 4. Logika Upload File QRIS
        if ($request->hasFile('qris_file')) {
            // Hapus file QRIS lama jika ada di storage
            if ($profile->qris_code && Storage::disk('public')->exists($profile->qris_code)) {
                Storage::disk('public')->delete($profile->qris_code);
            }

            // Simpan file baru ke folder 'public/qris'
            $path = $request->file('qris_file')->store('qris', 'public');
            $data['qris_code'] = $path;
        }

        // 5. Isi data ke model
        $profile->fill($data);

        // 6. Update timestamp kustom 'Updated_at'
        // Menggunakan now() agar tersimpan waktu perubahan terbaru
        $profile->Updated_at = now();

        $profile->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile berhasil diperbarui',
            'data' => $profile
        ]);
    }
}
