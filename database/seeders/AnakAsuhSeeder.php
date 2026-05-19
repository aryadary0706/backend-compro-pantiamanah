<?php

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
                'tanggal_lahir' => '2014-05-15',
                'tempat_lahir' => 'Jakarta',
                'gender' => 'Laki-laki',
                'education' => 'SD',
                'education_level' => 'Kelas 4',
                'status' => 'Yatim',
                'description' => 'Anak yang rajin membantu teman.',
                'photo' => 'anak_asuh/test-image_anakasuh1.jpeg',
            ],
            [
                'name' => 'Siti Aminah',
                'age' => 12,
                'tanggal_lahir' => '2012-08-20',
                'tempat_lahir' => 'Bandung',
                'gender' => 'Perempuan',
                'education' => 'SMP',
                'education_level' => 'Kelas 7',
                'status' => 'Dhuafa',
                'description' => 'Juara lomba matematika tingkat kota.',
                'photo' => 'anak_asuh/test-image-anakasuh2.jpeg',
            ],
            [
                'name' => 'Andi Wijaya',
                'age' => 8,
                'tanggal_lahir' => '2016-03-10',
                'tempat_lahir' => 'Surabaya',
                'gender' => 'Laki-laki',
                'education' => 'SD',
                'education_level' => 'Kelas 2',
                'status' => 'Piatu',
                'description' => 'Suka menggambar dan mewarnai.',
            ],
        ];

        foreach ($data as $item) {
            AnakAsuh::create($item);
        }
    }
}
