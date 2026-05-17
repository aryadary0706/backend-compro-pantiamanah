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
                'tanggal_lahir' => '2014-05-15',
                'education' => 'SD Negeri 01',
                'badge' => 'Rajin',
                'description' => 'Anak yang rajin membantu teman.',
                'photo' => 'anak_asuh/test-image_anakasuh1.jpeg',
            ],
            [
                'name' => 'Siti Aminah',
                'age' => 12,
                'gender' => 'Perempuan',
                'tanggal_lahir' => '2012-08-20',
                'education' => 'SMP IT Al-Ikhlas',
                'badge' => 'Berprestasi',
                'description' => 'Juara lomba matematika tingkat kota.',
                'photo' => 'anak_asuh/test-image-anakasuh2.jpeg',
            ],
            [
                'name' => 'Andi Wijaya',
                'age' => 8,
                'gender' => 'Laki-laki',
                'tanggal_lahir' => '2016-03-10',
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
