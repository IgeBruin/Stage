<?php

namespace Database\Seeders;

require_once 'vendor/autoload.php';

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\Specification;

class SpecificationsSeeder extends Seeder
{
    public function run()
    {
        Specification::create(['name' => 'Lengte']);
        Specification::create(['name' => 'Gewicht']);
        Specification::create(['name' => 'Kleur']);
        Specification::create(['name' => 'Breedte']);
        Specification::create(['name' => 'Hoogte']);
    }
}
