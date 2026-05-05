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
        // Gunakan map untuk menambahkan URL lengkap dari S3 ke setiap item
        $galleries = Gallery::latest()->get()->map(function ($item) {
            $item->image_url = $item->image_path ? Storage::cloud()->url($item->image_path) : null;
            return $item;
        });

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
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'uploaded_at' => 'required|date',
            ]);

            // Upload image ke S3 (Supabase)
            // Pastikan folder 'galleries' sudah sesuai dengan keinginan Anda
            $path = $request->file('image')->store('galleries', 's3');

            $gallery = Gallery::create([
                'title' => $validated['title'],
                'image_path' => $path,
                'uploaded_at' => $validated['uploaded_at'],
            ]);

            // Tambahkan URL agar response JSON lengkap
            $gallery->image_url = Storage::cloud()->url($path);

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
                'data' => null,
                'errors' => null
            ], 404);
        }

        // PENTING: Hapus file fisik dari Supabase Storage
        if ($gallery->image_path) {
            Storage::disk('s3')->delete($gallery->image_path);
        }

        // Baru hapus data dari database PostgreSQL
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gallery berhasil dihapus',
            'data' => null,
            'errors' => null
        ]);
    }
}
