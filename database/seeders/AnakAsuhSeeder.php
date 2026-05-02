<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnakAsuh;

class AnakAsuhSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Budi Santoso',
                'age' => 10,
                'gender' => 'Laki-laki',
                'education' => 'SD Negeri 01',
                'badge' => 'Rajin',
                'description' => 'Anak yang rajin membantu teman.',
                'photo' => 'photos/anak_asuh/test-image_anakasuh1.jpeg',
            ],
            [
                'name' => 'Siti Aminah',
                'age' => 12,
                'gender' => 'Perempuan',
                'education' => 'SMP IT Al-Ikhlas',
                'badge' => 'Berprestasi',
                'description' => 'Juara lomba matematika tingkat kota.',
            ],
            [
                'name' => 'Andi Wijaya',
                'age' => 8,
                'gender' => 'Laki-laki',
                'education' => 'SD Negeri 05',
                'badge' => 'Kreatif',
                'description' => 'Suka menggambar dan mewarnai.',
            ],
        ];

        foreach ($data as $item) {
            AnakAsuh::create($item);
        }
    }
}
