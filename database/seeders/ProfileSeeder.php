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
            'phone_number' => '02212345678',
            'Whatsapp_number' => '08156209910',
            'whatsapp_link' => 'https://wa.me/08156209910',
            'qris_code' => 'qris/qris_panti_amanah.png',
            'Updated_at' => now(),
        ]);
    }
}
