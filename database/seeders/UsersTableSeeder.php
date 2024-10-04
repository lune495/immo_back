<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'aliouneCIS',
                'email' => 'badaralune9@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 1, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'badaraADAJ',
                'email' => 'badaralune10@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 2, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
