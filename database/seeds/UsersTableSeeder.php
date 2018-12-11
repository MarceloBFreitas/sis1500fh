<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Paulo Seixas',
            'email' => 'pseixas@1500fh.com',
            'password' => bcrypt('123456'),
            'nivelacesso' => 1,
        ]);

        \App\User::create([
            'name' => 'Marcelo Buratti de Freitas',
            'email' => 'mfreitas@1500fh.com',
            'password' => bcrypt('123456'),
            'nivelacesso' => 3,
        ]);
        \App\User::create([
            'name' => 'Vitor Matheus Buratti de Freitas',
            'email' => 'vfreitas@1500fh.com',
            'password' => bcrypt('123456'),
            'nivelacesso' => 3,
        ]);
        \App\User::create([
            'name' => 'Marcio Santana',
            'email' => 'msantana@1500fh.com',
            'password' => bcrypt('123456'),
            'nivelacesso' => 2,
        ]);

    }
}
