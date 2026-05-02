<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // CREATE: Menyimpan lokasi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'address'         => 'required|string',
            'google_maps_url' => 'nullable|url', // Memastikan format URL valid
        ]);

        $location = Location::create($validated);

        return response()->json([
            'message' => 'Lokasi berhasil ditambahkan',
            'data'    => $location
        ], 201);
    }

    // UPDATE: Memperbarui data lokasi yang sudah ada
    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $validated = $request->validate([
            'address'         => 'sometimes|required|string',
            'google_maps_url' => 'nullable|url',
        ]);

        $location->update($validated);

        return response()->json([
            'message' => 'Lokasi berhasil diperbarui',
            'data'    => $location
        ]);
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID, jika tidak ketemu otomatis kirim error 404
        $location = Location::findOrFail($id);

        // Proses penghapusan
        $location->delete();

        return response()->json([
            'message' => 'Data lokasi berhasil dihapus dari sistem.'
        ], 200);
    }

    // Optional: Menampilkan data saat ini (untuk membantu proses update)
    public function index()
    {
        return response()->json(Location::all());
    }
}
