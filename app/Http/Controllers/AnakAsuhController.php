<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnakAsuhController extends Controller
{
    // READ: Menampilkan semua data
    public function index()
    {
        $anakAsuh = AnakAsuh::all()->map(function ($item) {
            // Menghasilkan URL publik dari Supabase Storage jika ada path fotonya
            if ($item->photo) {
                $item->photo_url = Storage::disk('s3')->url($item->photo);
            }
            return $item;
        });
        
        return response()->json($anakAsuh);
    }

    // CREATE: Menambah data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'age'         => 'required|integer',
            'gender'      => 'required|in:Laki-laki,Perempuan',
            'education'   => 'required|string',
            'badge'       => 'nullable|string',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // 1. Simpan ke disk 's3' (Supabase)
            // Folder di bucket akan otomatis dibuat: photos/anak_asuh
            $path = $request->file('photo')->store('photos/anak_asuh', 's3');
            $validated['photo'] = $path;
        }

        $anakAsuh = AnakAsuh::create($validated);
        
        // Tambahkan URL agar response JSON langsung bisa dipakai frontend
        $anakAsuh->photo_url = $anakAsuh->photo ? Storage::disk('s3')->url($anakAsuh->photo) : null;

        return response()->json(['message' => 'Data berhasil dibuat', 'data' => $anakAsuh], 201);
    }

    // UPDATE: Mengubah data
    public function update(Request $request, $id)
    {
        $anakAsuh = AnakAsuh::findOrFail($id);

        $validated = $request->validate([
            'age'         => 'sometimes|integer',
            'education'   => 'sometimes|string',
            'badge'       => 'nullable|string',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // 1. Hapus foto lama dari Supabase jika ada
            if ($anakAsuh->photo) {
                Storage::disk('s3')->delete($anakAsuh->photo);
            }
            
            // 2. Upload foto baru ke Supabase (disk 's3')
            $path = $request->file('photo')->store('photos/anak_asuh', 's3');
            $validated['photo'] = $path;
        }

        $anakAsuh->update($validated);
        $anakAsuh->photo_url = $anakAsuh->photo ? Storage::disk('s3')->url($anakAsuh->photo) : null;

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $anakAsuh]);
    }

    // DELETE: Menghapus data dan file
    public function destroy($id)
    {
        $anakAsuh = AnakAsuh::findOrFail($id);

        // Hapus file dari Supabase sebelum menghapus record di database
        if ($anakAsuh->photo) {
            Storage::disk('s3')->delete($anakAsuh->photo);
        }

        $anakAsuh->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}