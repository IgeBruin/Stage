<?php

namespace Database\Seeders;

require_once 'vendor/autoload.php';

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Product::create([
            'name' => $faker->sentence(1), 
            "description" => $faker->sentence(15), 
            "image" => "images/products/placeholder.png",
            "price" => $faker->randomFloat(2, 0, 100),
            "vat" => $faker->numberBetween(5, 21),
            "stock" => $faker->randomDigit(),
            ]);
        }
    }
}
