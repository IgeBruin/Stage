<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use RecipeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusSeeder::class);
        $this->call(SpecificationsSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(ProjectsSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(RecipeSeeder::class);
    }
}
