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
                'description' => 'Program pendidikan dari SD hingga SMA dengan fasilitas lengkap dan guru berkualitas.',
                'date' => '2026-06-01',
                'location' => 'Gedung Utama',
                'time' => '08:00:00'
            ],
            [
                'title' => 'Pendidikan Agama',
                'description' => 'Tahfidz Quran, kajian Islam, dan pembinaan akhlak mulia sesuai tuntunan Al-Quran dan Sunnah.',
                'date' => '2026-06-02',
                'location' => 'Masjid Yayasan',
                'time' => '16:00:00'
            ],
            [
                'title' => 'Kesehatan',
                'description' => 'Pemeriksaan kesehatan rutin, gizi seimbang, dan akses ke fasilitas kesehatan yang memadai.',
                'date' => '2026-06-05',
                'location' => 'Klinik',
                'time' => '09:00:00'
            ],
            [
                'title' => 'Program Sosial',
                'description' => 'Kegiatan bakti sosial, keterampilan hidup, dan pengembangan kepribadian anak asuh.',
                'date' => '2026-06-10',
                'location' => 'Aula',
                'time' => '10:00:00'
            ],
            [
                'title' => 'Perpustakaan',
                'description' => 'Akses ke ribuan buku dan sumber belajar untuk menunjang pendidikan anak asuh.',
                'date' => '2026-06-12',
                'location' => 'Perpustakaan',
                'time' => '13:00:00'
            ],
            [
                'title' => 'Pengembangan Bakat',
                'description' => 'Ekstrakurikuler olahraga, seni, dan keterampilan untuk mengasah potensi anak.',
                'date' => '2026-06-15',
                'location' => 'Lapangan',
                'time' => '15:30:00'
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
