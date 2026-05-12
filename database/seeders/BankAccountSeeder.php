<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BankAccount;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'bank_name' => 'BCA',
                'account_number' => '1234567890',
                'account_holder' => 'Panti Asuhan Harapan'
            ],
            [
                'bank_name' => 'Mandiri',
                'account_number' => '98765443210',
                'account_holder' => 'Panti Asuhan Harapan 2'
            ]
        ];

        foreach ($data as $item) {
            BankAccount::create($item);
        }
    }
}
