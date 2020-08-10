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
            'f_name' => 'Infini',
            'code' => 'IIIIIIII',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'infini@gmail.com',
            'username' => 'infini',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);

        DB::table('users')->insert([
            'name' => 'Jean',
            'f_name' => 'Jean',
            'code' => 'JJJJJJJJ',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'jean@gmail.com',
            'username' => 'jean',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);

        DB::table('users')->insert([
            'name' => 'Claude',
            'f_name' => 'Calude',
            'code' => 'CCCCCCCC',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'claude@gmail.com',
            'username' => 'claude',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);
    }
}
