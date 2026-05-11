<?php

namespace App\Http\Controllers;

use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NeedController extends Controller
{
    /**
     * READ - List Need
     */
    public function index()
    {
        $Needs = Need::with('bankAccount')->latest()->get();

        if ($Needs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada data Need',
                'data' => [],
                'errors' => null
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar Need berhasil diambil',
            'data' => $Needs,
            'errors' => null
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
                'photo'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'bank_account_id'  => 'required|exists:bank_accounts,id',
                'target_amount'    => 'required|numeric|min:1',
            ]);

            if ($request->hasFile('photo')) {

                $validated['photo'] =
                    $request->file('photo')
                        ->store(
                            'needs',
                            'public'
                        );
            }

            $Need = Need::create($validated);

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

        $Need->delete();

        return response()->json([
            'success' => true,
            'message' => 'Need berhasil dihapus',
            'data' => null,
            'errors' => null
        ]);
    }

    public function update(Request $request, $id)
    {
        $need = Need::find($id);

        if (!$need) {

            return response()->json([
                'success' => false,
                'message' => 'Need tidak ditemukan',
            ], 404);
        }

        try {

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'bank_account_id'
                    => 'required|exists:bank_accounts,id',
                'target_amount'
                    => 'required|numeric|min:1',
            ]);

            if ($request->hasFile('photo')) {

                $validated['photo'] =
                    $request->file('photo')
                        ->store(
                            'needs',
                            'public'
                        );
            }

            $need->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Need berhasil diupdate',
                'data' => $need
            ]);

        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
