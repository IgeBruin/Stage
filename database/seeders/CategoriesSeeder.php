<?php

namespace Database\Seeders;

require_once 'vendor/autoload.php';

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        \App\Models\Category::create(['name' => 'Geen categorie', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Voetbal', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Tennis', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Basketbal', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Golf', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Honkbal ', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Tafeltennis', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Hockey', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Cricket', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
        \App\Models\Category::create(['name' => 'Waterpolo', "description" => $faker->sentence(15),"image" => "images/categories/placeholder.png",]);
    }
}
