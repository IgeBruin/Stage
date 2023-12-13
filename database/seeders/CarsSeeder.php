<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarsSeeder extends Seeder
{
    public function run()
    {
        $sampleCars = [
            [
                'title' => 'BMW 320i',
                'description' => 'Een stijlvolle sedan van BMW, ideaal voor wie op zoek is naar comfort en prestaties. Deze auto combineert elegantie met kracht en biedt een geweldige rijervaring.',
                'brand_id' => 3, // BMW
                'type_id' => 2,  // Sedan
                'year' => 2022,
                'mileage' => 12000,
                'mot' => now(),
                'price' => 14000,
                'fuel_id' => 1,
                'user_id' => 1,
            ],
            [
                'title' => 'Volvo XC90',
                'description' => 'Een luxe SUV van Volvo, ontworpen voor gezinnen die op zoek zijn naar ruimte en veiligheid. Met geavanceerde technologie en een elegant ontwerp biedt deze auto comfort en betrouwbaarheid.',
                'brand_id' => 8, // Volvo
                'type_id' => 3,  // 4x4
                'year' => 2021,
                'fuel_id' => 4,
                'mileage' => 15000,
                'mot' => now(),
                'price' => 61000,
                'user_id' => 1,
            ],
            [
                'title' => 'Tesla Roadster',
                'description' => 'Een elektrische sportwagen van Tesla, toonaangevend op het gebied van prestaties en duurzaamheid. Met baanbrekende technologieën en een futuristisch ontwerp biedt deze auto een unieke rijervaring.',
                'brand_id' => 10, // Tesla
                'type_id' => 2,  // Sedan (aanpassen indien nodig)
                'year' => 2023,
                'mileage' => 8000,
                'fuel_id' => 5,
                'mot' => now(),
                'price' => 430000,
                'user_id' => 1,
            ],
            [
                'title' => 'Lotus Eletre',
                'description' => 'Een krachtige elektrische auto van Lotus, perfect voor liefhebbers van snelheid en elegantie. Met een opvallend ontwerp en geavanceerde technologieën levert deze stationwagen een opwindende rijervaring.',
                'brand_id' => 11, // Lotus
                'type_id' => 1,  // Stationwagen (aanpassen indien nodig)
                'year' => 2022,
                'fuel_id' => 5,
                'mileage' => 5000,
                'mot' => now(),
                'price' => 76000,
                'user_id' => 1,
            ],
            [
                'title' => 'Jaguar I Pace',
                'description' => 'Een elektrische SUV van Jaguar, combineert stijl en prestaties voor avontuurlijke rijders. Met geavanceerde technologie en een ruim interieur biedt deze auto comfort en duurzaamheid.',
                'brand_id' => 7, // Jaguar
                'type_id' => 3,  // 4x4
                'year' => 2021,
                'fuel_id' => 5,
                'mileage' => 18000,
                'mot' => now(),
                'price' => 60000,
                'user_id' => 1,
            ],
        ];

        foreach ($sampleCars as $carData) {
            Car::create($carData);
        }
    }
}
