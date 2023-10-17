<?php

namespace Database\Seeders;

require_once 'vendor/autoload.php';
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\Recipe;

class RecipesSeeder extends Seeder
{
    public function run()
    {
        Recipe::create([
            'user_id' => 1,
            'title' => 'Pasta Carbonara',
            'description' => 'A classic Italian pasta dish.',
            "image" => "images/recipes/placeholder.png",
            'instructions' => '1. Boil pasta until al dente.
2. In a separate pan, cook pancetta until crispy.
3. Whisk together eggs, Parmesan, and black pepper.
4. Drain pasta and toss it with the egg mixture.
5. Add the crispy pancetta on top.
6. Serve immediately and enjoy!'
        ]);

        Recipe::create([
            'user_id' => 1,
            'title' => 'Chicken Alfredo',
            'description' => 'Creamy chicken and pasta dish.',
            "image" => "images/recipes/placeholder.png",
            'instructions' => '1. Cook chicken in a pan until no longer pink.
2. Prepare Alfredo sauce with cream, butter, and Parmesan.
3. Cook pasta until al dente.
4. Combine cooked chicken, Alfredo sauce, and pasta.
5. Serve hot.'
        ]);
    }
}
