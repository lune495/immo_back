<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newrole = Role::where('nom','ADMIN')->first();
        if(!isset($newrole))
        {
              DB::table('roles')->insert([
                'nom'=>'ADMIN',
              ]);
        }   
    }
}
