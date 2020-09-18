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

        DB::table('users')->insert([
            'name' => 'Proprio',
            'f_name' => 'Proprio',
            'code' => 'PPPPPPPP',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'p@gmail.com',
            'username' => 'p',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);

        DB::table('users')->insert([
            'name' => 'Transpo',
            'f_name' => 'Transpo',
            'code' => 'TTTTTTTT',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 't@gmail.com',
            'username' => 't',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
        ]);

        DB::table('users')->insert([
            'name' => 'Chauffeur',
            'f_name' => 'Un',
            'code' => 'C1C1C1C1',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'c1@gmail.com',
            'username' => 'c1',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
            'user_chauffeur_id' => 5
        ]);

        DB::table('users')->insert([
            'name' => 'Chauffeur',
            'f_name' => 'Deux',
            'code' => 'C2C2C2C2',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'c2@gmail.com',
            'username' => 'c2',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
            'user_chauffeur_id' => 5
        ]);

        DB::table('users')->insert([
            'name' => 'Chauffeur',
            'f_name' => 'Un',
            'code' => 'C3C3C3C3',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'c3@gmail.com',
            'username' => 'c3',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
            'user_chauffeur_id' => 5
        ]);

        DB::table('users')->insert([
            'name' => 'Chauffeur',
            'f_name' => 'Un',
            'code' => 'C4C4C4C4',
            'phone' => '0000000000',
            'adresse' => 'Lomé',
            'is_actived' => true,
            'ville_id' => 1,
            'email' => 'c4@gmail.com',
            'username' => 'c4',
            'password' => '25d55ad283aa400af464c76d713c07ad', //-> 12345678,
            'user_chauffeur_id' => 5
        ]);
    }
}
