<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class log_klasifikasi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\log_klasifikasi::truncate();
        \App\Models\log_klasifikasi::factory(800)->create();
    }
}
