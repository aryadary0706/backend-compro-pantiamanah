<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class LocationController extends Controller
{
    // Menampilkan data saat ini (untuk membantu proses update)
    public function index()
    {
        try {
            $locations = Location::all();

            if ($locations->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Belum ada data lokasi',
                    'data'    => [],
                    'errors'  => null,
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Daftar lokasi berhasil diambil',
                'data'    => $locations,
                'errors'  => null,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lokasi',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    // CREATE: Menyimpan lokasi baru
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'address'         => 'required|string',
                'google_maps_url' => 'nullable|url',
            ]);

            $location = Location::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Lokasi berhasil ditambahkan',
                'data'    => $location,
                'errors'  => null,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data'    => null,
                'errors'  => $e->errors(),
            ], 422);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan lokasi',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    // UPDATE: Memperbarui data lokasi yang sudah ada
    public function update(Request $request, $id)
    {
        try {
            $location = Location::find($id);

            if (! $location) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi tidak ditemukan',
                    'data'    => null,
                    'errors'  => null,
                ], 404);
            }

            $validated = $request->validate([
                'address'         => 'sometimes|required|string',
                'google_maps_url' => 'nullable|url',
            ]);

            $location->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Lokasi berhasil diperbarui',
                'data'    => $location->fresh(),
                'errors'  => null,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data'    => null,
                'errors'  => $e->errors(),
            ], 422);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui lokasi',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    // DELETE: Menghapus data lokasi
    public function destroy($id)
    {
        try {
            $location = Location::find($id);

            if (! $location) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi tidak ditemukan',
                    'data'    => null,
                    'errors'  => null,
                ], 404);
            }

            $location->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data lokasi berhasil dihapus dari sistem',
                'data'    => null,
                'errors'  => null,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus lokasi',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }
}
