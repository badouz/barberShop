<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BarberShopsImage;
use App\Models\HasFactory;

class BarberShopsImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BarberShopsImage::factory()->count(10000)->create();
    }
}
