<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PacienteSeeder::class);
        $this->call(IndiceCardiacoSeeder::class);
        $this->call(IndicePulmonarSeeder::class);
    }
}
