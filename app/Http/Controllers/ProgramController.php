<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ProgramStoreRequest;
use App\Http\Requests\ProgramUpdateRequest;
use Throwable;

class ProgramController extends Controller
{
    /**
     * READ - Ambil semua program
     */
    public function index()
    {
        try {
            $programs = Program::latest()->get();

            if ($programs->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Belum ada data program',
                    'data'    => [],
                    'errors'  => null,
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Daftar program berhasil diambil',
                'data'    => $programs,
                'errors'  => null,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar program',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * CREATE - Simpan program baru
     */
    public function store(ProgramStoreRequest $request)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('images')) {
                $validated['images'] = $request->file('images')->store('programs', 'public');
            }

            $program = Program::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Program berhasil dibuat',
                'data'    => $program,
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
                'message' => 'Gagal membuat program',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * UPDATE - Perbarui program
     */
    public function update(ProgramUpdateRequest $request, $id)
    {
        try {
            $program = Program::find($id);

            if (! $program) {
                return response()->json([
                    'success' => false,
                    'message' => 'Program tidak ditemukan',
                    'data'    => null,
                    'errors'  => null,
                ], 404);
            }

            $validated = $request->validated();

            if ($request->hasFile('images')) {
                if ($program->images) {
                    Storage::disk('public')->delete($program->images);
                }
                $validated['images'] = $request->file('images')->store('programs', 'public');
            }

            $program->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Program berhasil diperbarui',
                'data'    => $program->fresh(),
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
                'message' => 'Gagal memperbarui program',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * DELETE - Hapus program
     */
    public function destroy($id)
    {
        try {
            $program = Program::find($id);

            if (! $program) {
                return response()->json([
                    'success' => false,
                    'message' => 'Program tidak ditemukan',
                    'data'    => null,
                    'errors'  => null,
                ], 404);
            }

            if ($program->images) {
                Storage::disk('public')->delete($program->images);
            }

            $program->delete();

            return response()->json([
                'success' => true,
                'message' => 'Program berhasil dihapus',
                'data'    => null,
                'errors'  => null,
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus program',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }
}
