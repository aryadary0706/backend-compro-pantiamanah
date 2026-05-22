<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProfileController extends Controller
{
    /**
     * Helper: ambil profile yang ada, atau buat instance baru (belum disimpan)
     */
    private function getProfile(): Profile
    {
        return Profile::first() ?? new Profile();
    }

    /**
     * READ - Ambil data profile
     */
    public function index()
    {
        try {
            $profile = Profile::first();

            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data profil belum dikonfigurasi.',
                    'data' => null,
                    'errors' => null,
                ], 404);
            }

            $data = $profile->toArray();

            if ($profile->qris_code) {
                $rawPath = $profile->getRawOriginal('qris_code');
                $data['qris_url'] = asset('storage/' . $rawPath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data profil berhasil diambil.',
                'data' => $data,
                'errors' => null,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data profil.',
                'data' => null,
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * UPDATE - Update data profile (Fokus pada Teks)
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'whatsapp_number' => 'required|string',
            'whatsapp_link' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'data' => null,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $profile = $this->getProfile();

            // fix: exclude 'qris_file' (nama field upload), bukan 'qris_code'
            // agar kolom qris_code tidak bisa ditimpa lewat body teks
            $profile->fill($request->except(['qris_file']));
            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
                'data' => $profile->fresh(),
                'errors' => null,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan profil.',
                'data' => null,
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * UPDATE - Upload / Ganti QRIS (Fokus pada File)
     */
    public function uploadQris(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qris_code' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'data' => null,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $profile = $this->getProfile();

            if ($profile->exists && $profile->qris_code) {
                $oldPath = $profile->getRawOriginal('qris_code');
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $request->file('qris_code')->store('qris', 'public');
            $profile->qris_code = $path;
            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'QRIS berhasil diperbarui.',
                'data' => array_merge($profile->toArray(), [
                    'qris_url' => asset('storage/' . $path),
                ]),
                'errors' => null,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload QRIS.',
                'data' => null,
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
