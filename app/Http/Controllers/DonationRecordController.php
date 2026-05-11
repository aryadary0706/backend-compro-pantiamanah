<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonationRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonationRecordController extends Controller
{
    /**
     * GET /api/donation-records
     * List semua donation records
     */

    public function index()
    {
        $records = DonationRecord::with(['need', 'bankAccount'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'List donation records',
            'data' => $records
        ]);
    }

    /**
     * POST /api/donation-records
     * Create donation record (public)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'donor_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'tujuan' => 'required|string|max:255',
            'donasi_id' => 'nullable|exists:needs,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'amount' => 'required|numeric|min:1000',
            'payment_proof' => 'required|image|max:2048',
        ]);

        // upload bukti pembayaran
        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] =
                $request->file('payment_proof')
                    ->store(
                        'payment_proofs',
                        'public'
                    );
        }

        $record = DonationRecord::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Donasi berhasil dicatat, menunggu verifikasi admin',
            'data' => $record
        ], 201);
    }
    /**
     * GET /api/donation-records/{id}
     * Detail donation record
     */
    public function show($id)
    {
        $record = DonationRecord::with(['need', 'bankAccount'])->find($id);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Donation record tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail donation record',
            'data' => $record
        ]);
    }

    public function destroy($id)
    {
        $record = DonationRecord::findOrFail($id);

        if ($record->payment_proof) {

            Storage::disk('public')
                ->delete($record->payment_proof);
        }

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Donation record berhasil dihapus'
        ]);
    }

    public function update(Request $request, $id)
    {
        $record = DonationRecord::find($id);

        if (!$record) {

            return response()->json([
                'success' => false,
                'message' => 'Donation tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'donor_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'tujuan' => 'required|string|max:255',
            'donasi_id' => 'nullable|exists:needs,id',
            'bank_account_id'
                => 'required|exists:bank_accounts,id',
            'amount' => 'required|numeric|min:1000',
        ]);

        $record->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Donation berhasil diupdate',
            'data' => $record
        ]);
    }
}
