<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        
        $user1 = User::create([
        'name' => 'ige bruin',
        'email' => 'igebruin2004@gmail.com',
        'password' => Hash::make('12345678'),
        ]);
        

        $user2 = User::create([
        'name' => 'Werknemer',
        'email' => 'werknemer@example.com',
        'password' => Hash::make('werknemer'),
        ]);
        

        $user3 = User::create([
        'name' => 'Bezoeker',
        'email' => 'Bezoeker@example.com',
        'password' => Hash::make('bezoeker'),
        ]);
        
    }
}
