<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Validation\ValidationException;

class GalleryController extends Controller
{
    /**
     * READ - List gallery
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();

        if ($galleries->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada data gallery',
                'data' => [],
                'errors' => null
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar gallery berhasil diambil',
            'data' => $galleries,
            'errors' => null
        ]);
    }

    /**
     * CREATE - Tambah gallery
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'required|image||max:2048',
                'uploaded_at' => 'required|date',
            ]);

            $path = $request->file('image')->store('galleries', 'public');

            $gallery = Gallery::create([
                'title' => $validated['title'],
                'image_path' => $path,
                'uploaded_at' => $validated['uploaded_at'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Gallery berhasil dibuat',
                'data' => $gallery,
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
     * DELETE - Hapus gallery
     */
    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery tidak ditemukan',
            ], 404);
        }

        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery berhasil dihapus',
        ]);
    }

        /**
        * UPDATE - Update gallery
        */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery tidak ditemukan',
            ], 404);
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'uploaded_at' => 'required|date',
            ]);

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($gallery->image_path) {
                    Storage::disk('public')->delete($gallery->image_path);
                }

                // Upload gambar baru
                $path = $request->file('image')->store('galleries', 'public');
                $gallery->image_path = $path;
            }

            $gallery->title = $validated['title'];
            $gallery->uploaded_at = $validated['uploaded_at'];
            $gallery->save();

            return response()->json([
                'success' => true,
                'message' => 'Gallery berhasil diperbarui',
                'data' => $gallery,
                'errors' => null
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => null,
                'errors' => $e->errors()
            ], 422);
        }
    }
}
