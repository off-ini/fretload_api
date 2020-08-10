<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'name' => 'Infini',
            'code' => 'IIIIIIII',
            'email' => 'infini@gmail.com',
            'username' => 'infini',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);

        DB::table('users')->insert([
            'name' => 'Jean',
            'code' => 'JJJJJJJJ',
            'email' => 'jean@gmail.com',
            'username' => 'jean',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);

        DB::table('users')->insert([
            'name' => 'Claude',
            'code' => 'CCCCCCCC',
            'email' => 'claude@gmail.com',
            'username' => 'claude',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);
    }
}
