<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Need;

class DonasiSeeder extends Seeder
{
    public function run(): void
    {
        $donasis = [
            [
                'title' => 'Donasi Pendidikan Anak',
                'description' => 'Mendukung pendidikan anak-anak panti.',
                'photo' => null,
                'bank_account_id' => 1,
                'target_amount' => 10000000,
                'collected_amount' => 2500000,
            ],
            [
                'title' => 'Donasi Renovasi Gedung',
                'description' => 'Renovasi ruang tidur dan belajar.',
                'photo' => null,
                'bank_account_id' => 1,
                'target_amount' => 20000000,
                'collected_amount' => 5000000,
            ],
            [
                'title' => 'Donasi Makan Sehat',
                'description' => 'Penyediaan makanan bergizi.',
                'photo' => null,
                'bank_account_id' => 1,
                'target_amount' => 5000000,
                'collected_amount' => 1500000,
            ],
            [
                'title' => 'Donasi Perlengkapan Sekolah',
                'description' => 'Tas, buku, dan alat tulis.',
                'photo' => null,
                'bank_account_id' => 1,
                'target_amount' => 7000000,
                'collected_amount' => 2000000,
            ],
            [
                'title' => 'Donasi Kesehatan',
                'description' => 'Pemeriksaan kesehatan rutin.',
                'photo' => null,
                'bank_account_id' => 1,
                'target_amount' => 8000000,
                'collected_amount' => 3000000,
            ],
            [
                'title' => 'Donasi Ramadhan',
                'description' => 'Santunan dan buka puasa bersama.',
                'photo' => null,
                'bank_account_id' => 1,
                'target_amount' => 12000000,
                'collected_amount' => 4000000,
            ],
        ];

        foreach ($donasis as $donasi) {
            Need::create($donasi);
        }
    }
}
