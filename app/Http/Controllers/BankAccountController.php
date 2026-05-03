<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BankAccountController extends Controller
{
    /**
     * READ - Ambil semua rekening bank
     */
    public function index()
    {
        $accounts = BankAccount::latest()->get();

        if ($accounts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Belum ada data rekening bank',
                'data' => [],
                'errors' => null
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar rekening bank berhasil diambil',
            'data' => $accounts,
            'errors' => null
        ], 200);
    }

    /**
     * CREATE - Simpan rekening bank baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'bank_name'       => 'required|string|max:255',
                'account_number'  => 'required|string|max:255',
                'account_holder'  => 'required|string|max:255',
            ]);

            $account = BankAccount::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Rekening bank berhasil dibuat',
                'data' => $account,
                'errors' => null
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Semua field wajib diisi',
                'data' => null,
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * READ - Detail rekening bank
     */
    public function show($id)
    {
        $account = BankAccount::find($id);

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening bank tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail rekening bank berhasil diambil',
            'data' => $account,
            'errors' => null
        ], 200);
    }

    /**
     * UPDATE - Perbarui rekening bank
     */
    public function update(Request $request, $id)
    {
        $account = BankAccount::find($id);

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening bank tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        try {
            $validated = $request->validate([
                'bank_name'       => 'required|string|max:255',
                'account_number'  => 'required|string|max:255',
                'account_holder'  => 'required|string|max:255',
            ]);

            $account->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Rekening bank berhasil diperbarui',
                'data' => $account,
                'errors' => null
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Semua field tidak boleh kosong',
                'data' => null,
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * DELETE - Hapus rekening bank
     */
    public function destroy($id)
    {
        $account = BankAccount::find($id);

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening bank tidak ditemukan',
                'data' => null,
                'errors' => null
            ], 404);
        }

        $account->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rekening bank berhasil dihapus',
            'data' => null,
            'errors' => null
        ], 200);
    }
}
