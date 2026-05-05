<?php

namespace App\Http\Controllers;

use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;

class NeedController extends Controller
{
    /**
     * READ - List Need
     */
    public function index()
    {
        $Needs = Need::with('bankAccount')->latest()->get()->map(function ($need) {
            $need->photo_url = $need->photo ? Storage::cloud()->url($need->photo) : null;
            return $need;
        });

        return response()->json([
            'success' => true,
            'message' => 'Daftar Need berhasil diambil',
            'data' => $Needs
        ]);
    }

    /**
     * CREATE - Buat Need
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'            => 'required|string|max:255',
                'description'      => 'required|string',
                'photo'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'bank_account_id'  => 'required|exists:bank_accounts,id',
                'target_amount'    => 'required|numeric|min:1',
            ]);

            if ($request->hasFile('photo')) {
                $validated['photo'] = $request->file('photo')->store('needs', 's3');
            }

            $Need = Need::create($validated);
            $Need->photo_url = $Need->photo ? Storage::cloud()->url($Need->photo) : null;

            return response()->json([
                'success' => true,
                'message' => 'Need berhasil dibuat',
                'data' => $Need->load('bankAccount'),
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
     * READ - Detail Need
     */
    public function show($id)
    {
        $Need = Need::with('bankAccount')->find($id);

        if (!$Need) {
            return response()->json([
                'success' => false,
                'message' => 'Need tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Need berhasil diambil',
            'data' => $Need,
            'errors' => null
        ]);
    }

    /**
     * DELETE - Hapus Need
     */
    public function destroy($id)
    {
        $Need = Need::find($id);

        if (!$Need) {
            return response()->json([
                'success' => false,
                'message' => 'Need tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        if ($Need->photo) {
            Storage::disk('s3')->delete($Need->photo);
        }

        $Need->delete();

        return response()->json([
            'success' => true,
            'message' => 'Need berhasil dihapus',
            'data' => null,
            'errors' => null
        ]);
    }
}
