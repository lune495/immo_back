<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = array();
        array_push($users,array("name" => "Admin" , "email" => "admin@gmail.com" ,"password" => "admin@2022","role_id" => "1"));
        $newuser = User::where('email', $users[0]['email'])->first();
        if (!isset($newuser))
        {
            $newuser = new User();
            $newuser->name = $users[0]['name'];
            $newuser->name = $users[0]['email'];
            $newuser->name = $users[0]['password'];
            $newuser->role_id = $users[0]['role_id'];
        }
            $newuser->email = $users[0]['email'];
        if (!isset($newuser->id))
        {
            $newuser->password = bcrypt($users[0]['password']);
        }
        $newuser->save();
    }
}
