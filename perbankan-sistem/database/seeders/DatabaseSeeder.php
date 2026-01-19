<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // JANGAN panggil UserSeeder default
        // $this->call(UserSeeder::class);
        
        // Panggil seeder kita saja
        $this->call(PerbankanSeeder::class);
    }
}