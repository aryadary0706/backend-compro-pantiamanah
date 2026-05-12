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

        return response()->json([
            'status' => 'success',
            'data' => $profile
        ]);
    }

    /**
     * UPDATE - Update data profile (Fokus pada Teks)
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $profile = Profile::firstOrNew();

        $data = $request->except(['qris_code']);

        $profile->fill($data);
        $profile->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profile berhasil diperbarui',
            'data' => $profile
        ]);
    }

    /**
     * UPDATE - Upload / Ganti QRIS (Fokus pada File)
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

        if ($profile->qris_code) {
            $oldPath = method_exists($profile, 'getRawOriginal')
                       ? $profile->getRawOriginal('qris_code')
                       : $profile->qris_code;

            Storage::disk('public')->delete($oldPath);
        }

        $path = $request->file('qris_file')->store('qris', 'public');
        $profile->qris_code = $path;
        $profile->save();

        return response()->json([
            'status' => 'success',
            'message' => 'QRIS berhasil diperbarui',
            'data' => $profile
        ]);
    }
}
