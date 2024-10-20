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
            ['nom_structure' => 'AGENCE ADMIN', 'telephone' => '0000000000','adresse' => 'ADRESSE TEST','created_at' => now(), 'updated_at' => now()],
            // ['nom_structure' => 'CIS', 'telephone' => '338671686','adresse' => 'TALY WALLY','created_at' => now(), 'updated_at' => now()],
            // ['nom_structure' => 'ADAJ', 'telephone' => '775875649','adresse' => 'KEUR NDIAYE LO','created_at' => now(), 'updated_at' => now()],
            // ['nom_structure' => 'MAME MALICK SY MANSOUR', 'telephone' => '77 612 90 72','adresse' => 'Keur Massard/En Face Brioche dOrée Près du PAMECAS','created_at' => now(), 'updated_at' => now()],
        ]);
    }
}