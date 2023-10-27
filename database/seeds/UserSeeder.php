<?php

use Illuminate\Database\Seeder;
use App\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=> 'Douglas',
            'email'=> 'dougrhis857@gmail.com',
            'password'=> bcrypt('12345678')
        ]);

        User::create([
            'name'=> 'Roberto',
            'email'=> 'robertojuarezwp@gmail.com',
            'password'=> bcrypt('12345678')
        ]);
    }
}
