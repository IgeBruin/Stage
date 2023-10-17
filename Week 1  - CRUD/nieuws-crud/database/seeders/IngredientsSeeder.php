<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            
        Ingredient::create(['name' => 'Zout']);
        Ingredient::create(['name' => 'Peper']);
        Ingredient::create(['name' => 'Olijfolie']);
        Ingredient::create(['name' => 'Bloem']);
        Ingredient::create(['name' => 'Suiker']);
        Ingredient::create(['name' => 'Knoflook']);
        Ingredient::create(['name' => 'Ui']);
        Ingredient::create(['name' => 'Boter']);
        Ingredient::create(['name' => 'Eieren']);
        Ingredient::create(['name' => 'Melk']);
        Ingredient::create(['name' => 'Tomaten']);
        Ingredient::create(['name' => 'Paprika']);
        Ingredient::create(['name' => 'Champignons']);
        Ingredient::create(['name' => 'Rijst']);
        Ingredient::create(['name' => 'Pasta']);
        Ingredient::create(['name' => 'Kip']);
        Ingredient::create(['name' => 'Rundvlees']);
        Ingredient::create(['name' => 'Vis']);
        Ingredient::create(['name' => 'Citroen']);
        Ingredient::create(['name' => 'Tijm']);
        Ingredient::create(['name' => 'Rozemarijn']);
        Ingredient::create(['name' => 'Basilicum']);
        Ingredient::create(['name' => 'Komkommer']);
        Ingredient::create(['name' => 'Wortelen']);
        Ingredient::create(['name' => 'Spinazie']);
        Ingredient::create(['name' => 'Broccoli']);
        Ingredient::create(['name' => 'Aardappelen']);
        Ingredient::create(['name' => 'Gember']);
        Ingredient::create(['name' => 'Sojasaus']);
        Ingredient::create(['name' => 'Honing']);
        Ingredient::create(['name' => 'Mosterd']);
        Ingredient::create(['name' => 'Worchester-saus']);
        Ingredient::create(['name' => 'Oregano']);
        Ingredient::create(['name' => 'Komijn']);
        Ingredient::create(['name' => 'Koriander']);
        Ingredient::create(['name' => 'Venkel']);
        Ingredient::create(['name' => 'Ansjovis']);
        Ingredient::create(['name' => 'Kappertjes']);
        Ingredient::create(['name' => 'Mayonaise']);
        Ingredient::create(['name' => 'Yoghurt']);
        Ingredient::create(['name' => 'Citroensap']);
        Ingredient::create(['name' => 'Appelazijn']);
        Ingredient::create(['name' => 'Balsamicoazijn']);
        Ingredient::create(['name' => 'Pindakaas']);
        Ingredient::create(['name' => 'Walnoten']);
        Ingredient::create(['name' => 'Amandelen']);
        Ingredient::create(['name' => 'Cashewnoten']);
        Ingredient::create(['name' => 'Kokosmelk']);
        Ingredient::create(['name' => 'Rode currypasta']);
        Ingredient::create(['name' => 'Garam masala']);
    }
}
