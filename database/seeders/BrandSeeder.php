<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run()
    {
        Brand::create(['name' => 'Koenigsegg']);
        Brand::create(['name' => 'Honda']);
        Brand::create(['name' => 'BMW']);
        Brand::create(['name' => 'Mazda']);
        Brand::create(['name' => 'Nissan']);
        Brand::create(['name' => 'Mitsubishi']);
        Brand::create(['name' => 'Jaquar']);
        Brand::create(['name' => 'Volvo']);
        Brand::create(['name' => 'Lexus']);
        Brand::create(['name' => 'Tesla']);
        Brand::create(['name' => 'Lotus']);
        Brand::create(['name' => 'Audi']);
        Brand::create(['name' => 'Mercedes-Benz']);
        Brand::create(['name' => 'Ford']);
    }
}
