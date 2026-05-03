<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
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
            ]);

            $program = Program::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Program berhasil dibuat',
                'data' => $program,
                'errors' => null
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Title dan description wajib diisi',
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
            ]);

            $program->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Program berhasil diperbarui',
                'data' => $program,
                'errors' => null
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Title dan description tidak boleh kosong',
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

        $program->delete();

        return response()->json([
            'success' => true,
            'message' => 'Program berhasil dihapus',
            'data' => null,
            'errors' => null
        ], 200);
    }
}
