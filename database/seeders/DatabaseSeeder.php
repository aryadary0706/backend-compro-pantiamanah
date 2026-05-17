<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProfileSeeder::class,
            LocationSeeder::class,
            AnakAsuhSeeder::class,
            ProgramSeeder::class,
            BankAccountSeeder::class,
            DonationRecordSeeder::class,
            GallerySeeder::class,
        ]);
    }
}
