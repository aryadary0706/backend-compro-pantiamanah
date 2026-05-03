<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            [
                'title' => 'Pendidikan Formal',
                'description' => 'Program pendidikan dari SD hingga SMA dengan fasilitas lengkap dan guru berkualitas.'
            ],
            [
                'title' => 'Pendidikan Agama',
                'description' => 'Tahfidz Quran, kajian Islam, dan pembinaan akhlak mulia sesuai tuntunan Al-Quran dan Sunnah.'
            ],
            [
                'title' => 'Kesehatan',
                'description' => 'Pemeriksaan kesehatan rutin, gizi seimbang, dan akses ke fasilitas kesehatan yang memadai.'
            ],
            [
                'title' => 'Program Sosial',
                'description' => 'Kegiatan bakti sosial, keterampilan hidup, dan pengembangan kepribadian anak asuh.'
            ],
            [
                'title' => 'Perpustakaan',
                'description' => 'Akses ke ribuan buku dan sumber belajar untuk menunjang pendidikan anak asuh.'
            ],
            [
                'title' => 'Pengembangan Bakat',
                'description' => 'Ekstrakurikuler olahraga, seni, dan keterampilan untuk mengasah potensi anak.'
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
