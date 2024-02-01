<?php

namespace Database\Seeders;

use App\Models\User; // Import the User class
use App\Models\Rol; // Import the Rol class

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate(); // Use the User class
        Rol::truncate(); // Use the Rol class
        
        $amountRol=2;
        Rol::factory($amountRol)->create();

        User::factory(5)->create()->each(function ($user) {
            $user->rol()->associate(Rol::all()->random())->save();
        });
    }
}
