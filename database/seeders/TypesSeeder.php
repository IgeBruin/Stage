<?php

namespace Database\Seeders;

require_once 'vendor/autoload.php';

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\models\Type;

class TypesSeeder extends Seeder
{
    public function run()
    {
        Type::create(['name' => 'Sportwagen']);
        Type::create(['name' => 'Stationwagen']);
        Type::create(['name' => 'Sedan']);
        Type::create(['name' => '4x4']);
        Type::create(['name' => 'Cabruio']);
        Type::create(['name' => 'Hatchback']);
        Type::create(['name' => 'Coupe']);
        Type::create(['name' => 'Bus']);
    }
}
