<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * READ - Ambil data profile
     */
    public function index()
    {
        $profile = Profile::first();

        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data profil belum dikonfigurasi.',
            ], 404);
        }

        $profile->qris_url = $profile->qris_code ? Storage::cloud()->url($profile->qris_code) : null;

        return response()->json([
            'status' => 'success',
            'data' => $profile
        ]);
    }

    /**
     * UPDATE - Update data profile (TANPA FILE)
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'email_information' => 'nullable|string',
            'phone_number' => 'required|string|max:20',
            'Whatsapp_number' => 'required|string',
            'contact_information' => 'nullable|string',
            'Operational_information' => 'nullable|string',
            'whatsapp_link' => 'nullable|url',
            'qris_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $profile = Profile::firstOrNew();
        $profile->fill($request->all());
        $profile->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile berhasil diperbarui',
            'data' => $profile
        ]);
    }

    /**
     * UPDATE - Upload / Ganti QRIS
     */
    public function uploadQris(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qris_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $profile = Profile::firstOrNew();

        //Hapus QRIS LAMA
        if ($profile->qris_code) {
            Storage::disk('s3')->delete($profile->qris_code);
        }

        // Simpan QRIS baru
        $path = $request->file('qris_file')->store('qris', 's3');
        $profile->qris_code = $path;
        $profile->save();

        $profile->qris_url = Storage::cloud()->url($path);

        return response()->json([
            'status' => 'success',
            'message' => 'QRIS berhasil diperbarui',
            'data' => $profile
        ]);
    }
}
