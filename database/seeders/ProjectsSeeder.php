<?php

namespace Database\Seeders;

require_once 'vendor/autoload.php';

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            \App\Models\Project::create([
                "name" => $faker->sentence(3),
                "introduction" => $faker->sentence(15),
                "content" => $faker->sentence(40),
                "start_date" => $faker->dateTimeBetween('-1 years', '+1 years'),
                "image" => "images/projects/placeholder.png",
            ]);
        }
    }
}
