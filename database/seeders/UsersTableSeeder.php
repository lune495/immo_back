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
                'name' => 'BAMBA',
                'email' => 'bamba_adaj@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 2, // Référence à ADAJ
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pape sall',
                'email' => 'papesall@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 3, // Référence à ADAJ
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HANNE',
                'email' => 'hanne@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 3, // Référence à ADAJ
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NDEYE AMI',
                'email' => 'ndeyeami_cis@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 1, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MAREME',
                'email' => 'mareme_cis@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 1, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MAÏMOUNA',
                'email' => 'maimouna_cis@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 1, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PAPE',
                'email' => 'pape_cis@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 1, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ABDOULAYE',
                'email' => 'abdoulaye_cis@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 1, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NIASSE',
                'email' => 'niasse_cis@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 1, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'badara',
                'email' => 'badaralune9@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 4, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bocar Diongue',
                'email' => 'bocardiongue@gmail.com',
                'password' => Hash::make('passer123'), // Utilisez un hash sécurisé pour les mots de passe
                'role_id' => 1, // Référence à Admin
                'structure_id' => 5, // Référence à CIS
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}