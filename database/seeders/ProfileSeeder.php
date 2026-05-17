<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::create([
            'email' => 'amanahpanti@gmail.com',
            'email_information' => 'Kontak resmi Panti Asuhan Amanah untuk administrasi dan kerjasama.',
            'phone_number' => '02212345678',
            'Whatsapp_number' => '012345678910',
            'contact_information' => 'Nomor Resmi Panti Asuhan Amanah sebagai opsi lain komunikasi',
            'Operational_information' => 'Senin - Sabtu: 08.00 - 17.00 WIB. Minggu: 09.00 - 15.00 WIB.',
            'whatsapp_link' => 'https://wa.me/012345678910',
            'qris_code' => 'qris/qris_baru.png',
            'Updated_at' => now(),
        ]);
    }
}
