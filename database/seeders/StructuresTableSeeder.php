<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StructuresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('structures')->insert([
            [
                'nom_structure' => '------CIS IMMOBILIER------', 
                'telephone' => '338671686', 
                'adresse' => 'TALY WALLY', 
                'tag_logo' => 'logo_cis.jpeg', 
                'numero_tel1_structure' => '', // Ajoutez une valeur par défaut ou vide
                'numero_tel2_structure' => '', // Ajoutez une valeur par défaut ou vide
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nom_structure' => '-- ADAJ IMMOBILIER --', 
                'telephone' => '775875649', 
                'adresse' => 'KEUR NDIAYE LO', 
                'tag_logo' => 'logo_adaj.jpeg', 
                'numero_tel1_structure' => '',
                'numero_tel2_structure' => '',
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nom_structure' => 'MAME MALICK SY MANSOUR', 
                'telephone' => '77 612 90 72', 
                'adresse' => 'Keur Massard/En Face Brioche dOrée Près du PAMECAS', 
                'tag_logo' => '', 
                'numero_tel1_structure' => '77 612 90 72', 
                'numero_tel2_structure' => '77 539 65 44', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'nom_structure' => 'AGENCE ADMIN', 
                'telephone' => '0000000000', 
                'adresse' => 'ADRESSE TEST', 
                'tag_logo' => '',
                'numero_tel1_structure' => '',
                'numero_tel2_structure' => '',
                'created_at' => now(), 
                'updated_at' => now()
            ],
             [
                'nom_structure' => 'BICO-IMMO', 
                'telephone' => '', 
                'adresse' => '', 
                'tag_logo' => '',
                'numero_tel1_structure' => '',
                'numero_tel2_structure' => '',
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}