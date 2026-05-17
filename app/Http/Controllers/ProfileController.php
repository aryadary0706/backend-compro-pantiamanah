<?php
namespace App\Http\Controllers;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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
        $profile = Profile::first();

        // Kalau belum ada data sama sekali, return 404
        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data profil belum dikonfigurasi.',
            ], 404);
        }

        $data = $profile->toArray();
        if ($profile->qris_code) {
            $data['qris_url'] = Storage::disk('public')->url($profile->getRawOriginal('qris_code'));
        }

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * UPDATE - Update data profile (Fokus pada Teks)
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'                   => 'required|email|max:255',
            'email_information'       => 'nullable|string',
            'phone_number'            => 'required|string|max:20',
            'Whatsapp_number'         => 'required|string',
            'contact_information'     => 'nullable|string',
            'Operational_information' => 'nullable|string',
            'whatsapp_link'           => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $profile = $this->getProfile();
            $profile->fill($request->except(['qris_code']));
            $profile->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Profile berhasil diperbarui',
                'data'    => $profile
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan profile: ' . $e->getMessage()
            ], 500);
        }
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

        try {
            $profile = $this->getProfile();

            if ($profile->exists && $profile->qris_code) {
                $oldPath = $profile->getRawOriginal('qris_code');
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $request->file('qris_file')->store('qris', 'public');
            $profile->qris_code = $path;
            $profile->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'QRIS berhasil diperbarui',
                'data'    => array_merge($profile->toArray(), [
                    'qris_url' => Storage::disk('public')->url($path)
                ])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengupload QRIS: ' . $e->getMessage()
            ], 500);
        }
    }
}
