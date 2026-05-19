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
        $bank1 = BankAccount::where('bank_name', 'BRI')->first();
        $bank2 = BankAccount::where('bank_name', 'Mandiri')->first();
        $bank3 = BankAccount::where('bank_name', 'BJB Syariah')->first();

        $donations = [
            [
                'donor_name' => 'Budi Sudarsono',
                'phone_number' => '081234567890',
                'payment_method' => 'bank_transfer',
                'tujuan' => 'Sedekah Makanan Buka Puasa',
                'bank_account_id' => $bank1->id ?? 1,
                'amount' => 500000.00,
                'payment_proof' => 'payment_proofs/bukti_transfer_sample.png',
            ],
            [
                'donor_name' => 'Siti Aminah',
                'phone_number' => '089988776655',
                'tujuan' => 'Pembangunan Asrama',
                'payment_method' => 'bank_transfer',
                'bank_account_id' => $bank2->id ?? 2,
                'amount' => 1250000.00,
                'payment_proof' => 'payment_proofs/bukti_transfer_sample.png',
            ],
            [
                'donor_name' => 'Hamba Allah',
                'phone_number' => '081122334455',
                'tujuan' => 'Zakat Mal',
                'payment_method' => 'bank_transfer',
                'bank_account_id' => $bank3->id ?? 3,
                'amount' => 250000.00,
                'payment_proof' => 'payment_proofs/bukti_transfer_sample.png',
            ],
            [
                'donor_name' => 'Ahmad Fauzi',
                'phone_number' => '082233445566',
                'tujuan' => 'Infaq Pendidikan',
                'payment_method' => 'cash',
                'bank_account_id' => null, // Donasi tunai
                'amount' => 750000.00,
                'payment_proof' => null,
            ],
            [
                'donor_name' => 'Maria Ulfa',
                'phone_number' => '083344556677',
                'tujuan' => 'Sedekah Pakaian',
                'payment_method' => 'other',
                'bank_account_id' => null,
                'amount' => 300000.00,
                'payment_proof' => null,
            ],
        ];

        foreach ($donations as $donation) {
            DonationRecord::create($donation);
        }
    }
}
