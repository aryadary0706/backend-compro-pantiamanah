<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DonasiController extends Controller
{
    /**
     * READ - List donasi
     */
    public function index()
    {
        $donasis = Donasi::with('bankAccount')->latest()->get();

        if ($donasis->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada data donasi',
                'data' => [],
                'errors' => null
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar donasi berhasil diambil',
            'data' => $donasis,
            'errors' => null
        ]);
    }

    /**
     * CREATE - Buat donasi
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'            => 'required|string|max:255',
                'description'      => 'required|string',
                'photo'             => 'nullable|string',
                'bank_account_id'  => 'required|exists:bank_accounts,id',
                'target_amount'    => 'required|numeric|min:1',
            ]);

            $donasi = Donasi::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Donasi berhasil dibuat',
                'data' => $donasi->load('bankAccount'),
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
     * READ - Detail donasi
     */
    public function show($id)
    {
        $donasi = Donasi::with('bankAccount')->find($id);

        if (!$donasi) {
            return response()->json([
                'success' => false,
                'message' => 'Donasi tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail donasi berhasil diambil',
            'data' => $donasi,
            'errors' => null
        ]);
    }

    /**
     * DELETE - Hapus donasi
     */
    public function destroy($id)
    {
        $donasi = Donasi::find($id);

        if (!$donasi) {
            return response()->json([
                'success' => false,
                'message' => 'Donasi tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        $donasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Donasi berhasil dihapus',
            'data' => null,
            'errors' => null
        ]);
    }
}
