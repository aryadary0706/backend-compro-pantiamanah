<?php

namespace App\Http\Controllers;

use App\Models\AnakAsuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AnakAsuhStore;
use App\Http\Requests\AnakAsuhUpdate;
use Throwable;

class AnakAsuhController extends Controller
{
    public function index()
    {
        try {
            $anakAsuh = AnakAsuh::all();

            return response()->json([
                'success' => true,
                'message' => 'Daftar anak asuh berhasil diambil.',
                'data'    => $anakAsuh,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar anak asuh.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function pagination(Request $request)
    {
        try {
            $query = AnakAsuh::latest();

            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }

            $anakAsuh = $query->paginate(6);

            return response()->json([
                'success' => true,
                'message' => 'Daftar anak asuh berhasil diambil.',
                'data'    => $anakAsuh,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data anak asuh.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function store(AnakAsuhStore $request)
    {
        try {
            $validated = $request->validated();

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('anak_asuh', 'public');
            }

            $anakAsuh = AnakAsuh::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data anak asuh berhasil dibuat.',
                'data'    => $anakAsuh,
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat data anak asuh.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(AnakAsuhUpdate $request, $id)
    {
        try {
            $anakAsuh = AnakAsuh::find($id);

            if (! $anakAsuh) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data anak asuh tidak ditemukan.',
                ], 404);
            }

            $validated = $request->validated();

            if ($request->hasFile('photo')) {
                if ($anakAsuh->photo) {
                    Storage::disk('public')->delete($anakAsuh->photo);
                }
                $validated['photo'] = $request->file('photo')->store('anak_asuh', 'public');
            }

            $anakAsuh->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data anak asuh berhasil diperbarui.',
                'data'    => $anakAsuh->fresh(),
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data anak asuh.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $anakAsuh = AnakAsuh::find($id);

            if (! $anakAsuh) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data anak asuh tidak ditemukan.',
                ], 404);
            }

            if ($anakAsuh->photo) {
                Storage::disk('public')->delete($anakAsuh->photo);
            }

            $anakAsuh->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data anak asuh berhasil dihapus.',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data anak asuh.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
