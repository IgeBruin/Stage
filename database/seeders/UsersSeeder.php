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
            'name' => 'Ige Bruin',
            'email' => 'igebruin2004@gmail.com',
            'password' => Hash::make('12345678'),
            'address' => 'Kerkstraat 1',
            'phone' => '0612345678',
            'isAdmin' => true, 
        ]);
        

        $user2 = User::create([
            'name' => 'Werknemer',
            'email' => 'werknemer@example.com',
            'password' => Hash::make('werknemer'),
            'address' => 'Kerkstraat 2',
            'phone' => '0612345678',
            'isAdmin' => false, 
        ]);
        
        $user3 = User::create([
            'name' => 'Bezoeker',
            'email' => 'Bezoeker@example.com',
            'password' => Hash::make('bezoeker'),
            'address' => 'Kerkstraat 3',
            'phone' => '0612345678',
            'isAdmin' => false, 
        ]);
    }
}
