<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil UserSeeder kamu di sini
        $this->call([
            UserSeeder::class,
            FasilitasSeeder::class,
            LaporanRekapSeeder::class,
        ]);
    }
}
