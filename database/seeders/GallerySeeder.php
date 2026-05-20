<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Demo Presentasi website PSAA Amanah',
                'image_path' => 'galleries/foto_1.jpeg',
                'uploaded_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            Gallery::create($item);
        }
    }
}
