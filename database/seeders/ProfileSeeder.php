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
            'ketua_yayasan' => 'Ir. Budi Santoso',
            'tahun_periode' => '2026-2029',
            'profil_text' => 'Panti Asuhan Amanah adalah sebuah lembaga sosial yang berkomitmen memberikan pendidikan, kesehatan, dan perlindungan bagi anak-anak kurang mampu di Indonesia.',
            'email' => 'amanahpanti@gmail.com',
            'phone_number' => '02212345678',
            'whatsapp_number' => '08156209910',
            'whatsapp_link' => 'https://wa.me/08156209910',
            'instagram' => 'panti.amanah',
            'qris_code' => 'qris/qris_panti_amanah.png',
            'updated_at' => now(),
        ]);
    }
}
