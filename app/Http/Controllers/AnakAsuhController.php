<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnakAsuhController extends Controller
{
    public function index()
    {
        $anakAsuh = AnakAsuh::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar anak asuh berhasil diambil',
            'data' => $anakAsuh,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'age'         => 'required|integer',
            'tanggal_lahir' => 'required|date',
            'gender'      => 'required|in:Laki-laki,Perempuan',
            'education'   => 'required|string',
            'badge'       => 'nullable|string',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('anak_asuh', 'public');
        }

        $anakAsuh = AnakAsuh::create($validated);
        return response()->json(['message' => 'Data berhasil dibuat', 'data' => $anakAsuh], 201);
    }

    public function update(Request $request, $id)
    {
        $anakAsuh = AnakAsuh::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'age'         => 'sometimes|integer',
            'tanggal_lahir' => 'sometimes|date',
            'gender'      => 'sometimes|in:Laki-laki,Perempuan',
            'education'   => 'sometimes|string',
            'badge'       => 'nullable|string',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            if ($anakAsuh->photo) {
                Storage::disk('public')->delete($anakAsuh->photo);
            }
            $validated['photo'] = $request->file('photo')->store('anak_asuh', 'public');
        }

        $anakAsuh->update($validated);

        return response()->json([
            'message' => 'Data berhasil diperbarui',
             'data'   => $anakAsuh->fresh()
        ]);
    }

    public function destroy($id)
    {
        $anakAsuh = AnakAsuh::findOrFail($id);

        if ($anakAsuh->photo) {
            Storage::disk('public')->delete($anakAsuh->photo);
        }

        $anakAsuh->delete();
        return response()->json(['message' => 'Anak asuh berhasil dihapus']);
    }
}
