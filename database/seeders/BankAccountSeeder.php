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
                'bank_name' => 'BRI',
                'account_number' => '0885 01 019662 53 4',
                'account_holder' => 'PSAA Amanah'
            ],
            [
                'bank_name' => 'Mandiri',
                'account_number' => '132 00 0495333 8',
                'account_holder' => 'PSAA Amanah'
            ],
            [
                'bank_name' => 'BJB Syariah',
                'account_number' => '53302060 00394',
                'account_holder' => 'PSAA Amanah'
            ],
        ];

        foreach ($data as $item) {
            BankAccount::create($item);
        }
    }
}
