<?php

namespace Database\Seeders;

use App\Models\DonationRecord;
use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class DonationRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil ID pertama dan terakhir dari BankAccount agar seeder tetap dinamis
        $bank1 = BankAccount::where('bank_name', 'BCA')->first();
        $bank2 = BankAccount::where('bank_name', 'Mandiri')->first();

        $donations = [
            [
                'donor_name' => 'Budi Sudarsono',
                'phone_number' => '081234567890',
                'tujuan' => 'Sedekah Makanan Buka Puasa',
                'bank_account_id' => $bank1->id ?? 1,
                'amount' => 500000.00,
                'payment_proof' => 'payment_proofs/bukti_transfer_sample.png',
            ],
            [
                'donor_name' => 'Siti Aminah',
                'phone_number' => '089988776655',
                'tujuan' => 'Pembangunan Asrama',
                'bank_account_id' => $bank2->id ?? 2,
                'amount' => 1250000.00,
                'payment_proof' => 'payment_proofs/bukti_transfer_sample.png',
            ],
            [
                'donor_name' => 'Hamba Allah',
                'phone_number' => '081122334455',
                'tujuan' => 'Zakat Mal',
                'bank_account_id' => $bank1->id ?? 1,
                'amount' => 250000.00,
                'payment_proof' => 'payment_proofs/bukti_transfer_sample.png',
            ],
        ];

        foreach ($donations as $donation) {
            DonationRecord::create($donation);
        }
    }
}
