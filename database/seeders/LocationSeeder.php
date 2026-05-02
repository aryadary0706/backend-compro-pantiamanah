<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'address' => 'Jl. Batununggal No.63A, Batununggal, Kec. Bandung Kidul, Kota Bandung, Jawa Barat 40266',
            'google_maps_url' => 'https://maps.app.goo.gl/gx8AZwjxQQrcG4cz5'
        ]);
    }
}
