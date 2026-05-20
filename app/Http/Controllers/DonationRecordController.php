<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DonationRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonationRecordController extends Controller
{
    public function index()
    {
        $records = DonationRecord::with(['bankAccount'])->latest()->get();

        $records->getCollection()->transform(function ($record) {
            $record->payment_proof_url =
                $record->payment_proof
                    ? url(
                        Storage::url(
                            $record->payment_proof
                        )
                    )
                    : null;

            return $record;
        });

        return response()->json([
            'success' => true,
            'message' => 'List donation records',
            'data' => $records
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donor_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'tujuan' => 'required|string|max:255',
            'payment_method' => 'required|in:bank_transfer,cash,qris,other',
            'bank_account_id' => 'required_if:payment_method,bank_transfer|nullable|exists:bank_accounts,id',
            'amount' => 'required|numeric|min:1000',
            'payment_proof' => 'required_if:payment_method,bank_transfer|nullable|image|max:2048',
        ]);

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

    public function show($id)
    {
        $record = DonationRecord::with(['bankAccount'])->find($id);

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Donation record tidak ditemukan'
            ], 404);
        }

        if ($record->payment_proof) {
            $record->payment_proof = url(Storage::url($record->payment_proof));
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
            'payment_method' => 'required|in:bank_transfer,cash,qris,other',
            'bank_account_id' => 'nullable|exists:bank_accounts,id',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'amount' => 'required|numeric|min:1000',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Hapus file lama
            if ($record->payment_proof && Storage::exists($record->payment_proof)) {
                Storage::delete($record->payment_proof);
            }
            $data['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        } else {
            // Jangan overwrite payment_proof jika tidak ada file baru
            unset($data['payment_proof']);
        }

        $record->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Donation berhasil diupdate',
            'data' => $record
        ]);
    }
}
