<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationRecordStoreRequest;
use App\Http\Requests\DonationRecordUpdateRequest;
use App\Models\DonationRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class DonationRecordController extends Controller
{
    /**
     * Helper: ubah path storage menjadi URL publik
     * Menghindari error Undefined method 'url' pada beberapa driver Storage
     */
    private function toPublicUrl(?string $path): ?string
    {
        return $path ? asset('storage/' . $path) : null;
    }

    /**
     * READ - Ambil semua donation record
     */
    public function index()
    {
        try {
            $records = DonationRecord::with(['bankAccount'])->latest()->get();

            $records->transform(function ($record) {
                $record->payment_proof = $this->toPublicUrl($record->getRawOriginal('payment_proof'));
                return $record;
            });

            return response()->json([
                'success' => true,
                'message' => 'List donation records',
                'data'    => $records,
                'errors'  => null,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar donasi.',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * READ - Pagination donation record
     */
    public function pagination(Request $request)
    {
        try {
            $records = DonationRecord::with(['bankAccount'])->latest()->paginate(4);

            $records->getCollection()->transform(function ($record) {
                $record->payment_proof = $this->toPublicUrl($record->getRawOriginal('payment_proof'));
                return $record;
            });

            return response()->json([
                'success' => true,
                'message' => 'List donation records',
                'data'    => $records,
                'errors'  => null,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data donasi.',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * CREATE - Simpan donation record baru
     */
    public function store(DonationRecordStoreRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('payment_proof')) {
                $data['payment_proof'] = $request->file('payment_proof')
                    ->store('payment_proofs', 'public');
            }

            $record = DonationRecord::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Donasi berhasil dicatat, menunggu verifikasi admin.',
                'data'    => $record,
                'errors'  => null,
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencatat donasi.',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * READ - Detail donation record
     */
    public function show($id)
    {
        try {
            $record = DonationRecord::with(['bankAccount'])->find($id);

            if (! $record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Donation record tidak ditemukan.',
                    'data'    => null,
                    'errors'  => null,
                ], 404);
            }

            $record->payment_proof = $this->toPublicUrl($record->getRawOriginal('payment_proof'));

            return response()->json([
                'success' => true,
                'message' => 'Detail donation record',
                'data'    => $record,
                'errors'  => null,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail donasi.',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * UPDATE - Perbarui donation record
     */
    public function update(DonationRecordUpdateRequest $request, $id)
    {
        try {
            $record = DonationRecord::find($id);

            if (! $record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Donation tidak ditemukan.',
                    'data'    => null,
                    'errors'  => null,
                ], 404);
            }

            $data = $request->validated();

            if ($request->hasFile('payment_proof')) {
                if ($record->payment_proof && Storage::disk('public')->exists($record->payment_proof)) {
                    Storage::disk('public')->delete($record->payment_proof);
                }
                $data['payment_proof'] = $request->file('payment_proof')
                    ->store('payment_proofs', 'public');
            } else {
                unset($data['payment_proof']);
            }

            $record->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Donation berhasil diupdate.',
                'data'    => $record->fresh(),
                'errors'  => null,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui donasi.',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * DELETE - Hapus donation record
     */
    public function destroy($id)
    {
        try {
            $record = DonationRecord::find($id);

            if (! $record) {
                return response()->json([
                    'success' => false,
                    'message' => 'Donation record tidak ditemukan.',
                    'data'    => null,
                    'errors'  => null,
                ], 404);
            }

            if ($record->payment_proof && Storage::disk('public')->exists($record->payment_proof)) {
                Storage::disk('public')->delete($record->payment_proof);
            }

            $record->delete();

            return response()->json([
                'success' => true,
                'message' => 'Donation record berhasil dihapus.',
                'data'    => null,
                'errors'  => null,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus donasi.',
                'data'    => null,
                'errors'  => $e->getMessage(),
            ], 500);
        }
    }
}
