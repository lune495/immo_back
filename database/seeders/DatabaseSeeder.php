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
        // Appel des seeders ici
        $this->call([
            RolesTableSeeder::class,
            StructuresTableSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}