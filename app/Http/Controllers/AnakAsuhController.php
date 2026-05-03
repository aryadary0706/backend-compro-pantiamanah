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
        $anakAsuh = AnakAsuh::all();
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
            $validated['photo'] = $request->file('photo')->store('photos/anak_asuh', 'public');
        }

        $anakAsuh = AnakAsuh::create($validated);
        return response()->json(['message' => 'Data berhasil dibuat', 'data' => $anakAsuh], 201);
    }

    // UPDATE: Hanya atribut tertentu (age, education, badge, description, photo)
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
            if ($anakAsuh->photo) {
                Storage::disk('public')->delete($anakAsuh->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos/anak_asuh', 'public');
        }
        $anakAsuh->update($validated);

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $anakAsuh]);
    }

    public function destroy($id)
    {
        $anakAsuh = AnakAsuh::findOrFail($id);
        if ($anakAsuh->photo) {
            Storage::disk('public')->delete($anakAsuh->photo);
        }
        $anakAsuh->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
