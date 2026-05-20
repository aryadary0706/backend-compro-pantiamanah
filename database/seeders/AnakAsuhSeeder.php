<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnakAsuh;

class AnakAsuhSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ==========================================
            // 1. Asrama Putra - Jl. Batununggal No. 63A
            // ==========================================

            // SD
            [
                'name'            => 'Cep Yudha',
                'age'             => 9,
                'tanggal_lahir'   => '2015-08-19',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SD',
                'education_level' => 'Kelas 4',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Muhamad Ardan Nirham',
                'age'             => 9,
                'tanggal_lahir'   => '2015-09-20',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SD',
                'education_level' => 'Kelas 4',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Khoirul Subagja',
                'age'             => 13,
                'tanggal_lahir'   => '2011-07-10',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SD',
                'education_level' => 'Kelas 6',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Julpa Maulidin',
                'age'             => 11,
                'tanggal_lahir'   => '2013-11-29',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SD',
                'education_level' => 'Kelas 6',
                'status'          => 'Dhuafa',
            ],

            // SMP
            [
                'name'            => 'Afka Sapta Maulana',
                'age'             => 13,
                'tanggal_lahir'   => '2011-09-26',
                'tempat_lahir'    => 'Banyumas',
                'gender'          => 'Laki-laki',
                'education'       => 'SMP',
                'education_level' => 'Kelas 8',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Fazar Fadilah',
                'age'             => 12,
                'tanggal_lahir'   => '2012-01-13',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMP',
                'education_level' => 'Kelas 8',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Ejar Raditia',
                'age'             => 14,
                'tanggal_lahir'   => '2010-01-07',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMP',
                'education_level' => 'Kelas 9',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Ripki Muhamad Taopik',
                'age'             => 15,
                'tanggal_lahir'   => '2009-07-29',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMP',
                'education_level' => 'Kelas 9',
                'status'          => 'Dhuafa',
            ],

            // SMA (SMK)
            [
                'name'            => 'Mirsal Fajhulah',
                'age'             => 15,
                'tanggal_lahir'   => '2009-08-20',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 11',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Johan Akhirudin',
                'age'             => 16,
                'tanggal_lahir'   => '2008-01-30',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 11',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Gilang Maulana',
                'age'             => 16,
                'tanggal_lahir'   => '2008-06-07',
                'tempat_lahir'    => 'Bandung',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 11',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Mutiara Nafis Kholisan',
                'age'             => 16,
                'tanggal_lahir'   => '2008-08-25',
                'tempat_lahir'    => 'Bandung',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 11',
                'status'          => 'Yatim',
            ],
            [
                'name'            => 'Adam',
                'age'             => 16,
                'tanggal_lahir'   => '2008-01-08',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 12',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Tegar',
                'age'             => 17,
                'tanggal_lahir'   => '2007-05-26',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 12',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Muhamad Akbar Mufaqih',
                'age'             => 17,
                'tanggal_lahir'   => '2007-09-27',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 12',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Janu Awaludin',
                'age'             => 19,
                'tanggal_lahir'   => '2006-01-01',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'SMA',
                'education_level' => 'Kelas 12',
                'status'          => 'Dhuafa',
            ],

            // Kuliah
            [
                'name'            => 'Irsal',
                'age'             => 20,
                'tanggal_lahir'   => '2004-03-01',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'Kuliah',
                'education_level' => 'Semester 3',
                'status'          => 'Piatu',
            ],
            [
                'name'            => 'Erik Abdul Hakim',
                'age'             => 20,
                'tanggal_lahir'   => '2004-11-30',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Laki-laki',
                'education'       => 'Kuliah',
                'education_level' => 'Semester 3',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'M. Rizal Silmi Kaffah',
                'age'             => 21,
                'tanggal_lahir'   => '2003-07-06',
                'tempat_lahir'    => 'Bandung',
                'gender'          => 'Laki-laki',
                'education'       => 'Kuliah',
                'education_level' => 'Semester 7',
                'status'          => 'Yatim',
            ],

            // =====================================================
            // 2. Asrama Putri - Jl. Kawaluyaan Indah X No. 6
            // =====================================================

            // SD
            [
                'name'            => 'Silfa Putri Ramdani',
                'age'             => 12,
                'tanggal_lahir'   => '2012-08-24',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Perempuan',
                'education'       => 'SD',
                'education_level' => 'Kelas 5',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Ashira Nur Azhira',
                'age'             => 11,
                'tanggal_lahir'   => '2013-12-29',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Perempuan',
                'education'       => 'SD',
                'education_level' => 'Kelas 6',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Destia',
                'age'             => 10,
                'tanggal_lahir'   => '2014-02-06',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Perempuan',
                'education'       => 'SD',
                'education_level' => 'Kelas 6',
                'status'          => 'Dhuafa',
            ],

            // SMP
            [
                'name'            => 'Alia Elpa Nur Athiran',
                'age'             => 13,
                'tanggal_lahir'   => '2011-08-03',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Perempuan',
                'education'       => 'SMP',
                'education_level' => 'Kelas 7',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Azwa Anggraeni',
                'age'             => 12,
                'tanggal_lahir'   => '2012-03-26',
                'tempat_lahir'    => 'Bandung',
                'gender'          => 'Perempuan',
                'education'       => 'SMP',
                'education_level' => 'Kelas 9',
                'status'          => 'Yatim',
            ],

            // SMA (SMK)
            [
                'name'            => 'Alifia Putri Rahayu',
                'age'             => 15,
                'tanggal_lahir'   => '2009-03-24',
                'tempat_lahir'    => 'Garut',
                'gender'          => 'Perempuan',
                'education'       => 'SMA',
                'education_level' => 'Kelas 10',
                'status'          => 'Dhuafa',
            ],
            [
                'name'            => 'Yusuf Zaina',
                'age'             => 15,
                'tanggal_lahir'   => '2009-10-08',
                'tempat_lahir'    => 'Bandung',
                'gender'          => 'Perempuan',
                'education'       => 'SMA',
                'education_level' => 'Kelas 10',
                'status'          => 'Dhuafa',
            ],

            // Kuliah
            [
                'name'            => 'Najmi Alliza',
                'age'             => 21,
                'tanggal_lahir'   => '2003-10-15',
                'tempat_lahir'    => 'Bandung',
                'gender'          => 'Perempuan',
                'education'       => 'Kuliah',
                'education_level' => 'Semester 7',
                'status'          => 'Dhuafa',
            ],
        ];

        foreach ($data as $item) {
            AnakAsuh::create($item);
        }
    }
}
