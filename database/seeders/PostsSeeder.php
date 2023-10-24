<?php

namespace Database\Seeders;

require_once 'vendor/autoload.php';

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            \App\Models\Post::create([
                "title" => $faker->sentence(3),
                "introduction" => $faker->sentence(15),
                "content" => $faker->sentence(40),
                "publication_date" => $faker->dateTimeBetween('-1 years', '+2 years'),
                "category_id" => $faker->randomElement([1,2,3,4,5,6,7,8,9,10,]), 
                "image" => "images/articles/placeholder.png",
            ]);
        }
    }
}
