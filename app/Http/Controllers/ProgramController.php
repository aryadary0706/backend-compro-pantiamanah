<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProgramController extends Controller
{
    /**
     * READ - Ambil semua program
     */
    public function index()
    {
        $programs = Program::latest()->get();

        if ($programs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada data program',
                'data' => [],
                'errors' => null
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar program berhasil diambil',
            'data' => $programs,
            'errors' => null
        ], 200);
    }

    /**
     * CREATE - Simpan program baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'date' => 'required|date',
                'location' => 'required|string|max:255',
                'time' => 'required'
            ]);

            $data = $validated;
            if ($request->hasFile('images')) {
                $data['images'] = $request->file('images')->store('programs', 'public');
            }

            $program = Program::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Program berhasil dibuat',
                'data' => $program,
                'errors' => null
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => null,
                'errors' => $e->errors()
            ], 422);
        }
    }
    
    /**
     * UPDATE - Perbarui program
     */
    public function update(Request $request, $id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'images' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'date' => 'nullable|date',
                'location' => 'nullable|string|max:255',
                'time' => 'nullable'
            ]);

            $data = $validated;
            if ($request->hasFile('images')) {
                if ($program->images) {
                    Storage::disk('public')->delete($program->images);
                }
                $data['images'] = $request->file('images')->store('programs', 'public');
            }

            $program->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Program berhasil diperbarui',
                'data' => $program,
                'errors' => null
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => null,
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * DELETE - Hapus program
     */
    public function destroy($id)
    {
        $program = Program::find($id);

        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        if ($program->images) {
            Storage::disk('public')->delete($program->images);
        }

        $program->delete();

        return response()->json([
            'success' => true,
            'message' => 'Program berhasil dihapus',
            'data' => null,
            'errors' => null
        ], 200);
    }
}
