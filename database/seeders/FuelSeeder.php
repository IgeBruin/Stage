<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fuel;

class FuelSeeder extends Seeder
{
    public function run()
    {
        $fuels = [
            ['name' => 'Benzine'],
            ['name' => 'Waterstof'],
            ['name' => 'Diesel'],
            ['name' => 'Hybride'],
            ['name' => 'Elektrisch'],
        ];

        foreach ($fuels as $fuel) {
            Fuel::create($fuel);
        }
    }
}
