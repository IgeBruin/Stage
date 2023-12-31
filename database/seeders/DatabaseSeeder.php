<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this->call(IngredientsSeeder::class);
        $this->call(TypesSeeder::class); 
        $this->call(BrandSeeder::class);   
        $this->call(FuelSeeder::class);   
        $this->call(CarsSeeder::class); 
    }
}
