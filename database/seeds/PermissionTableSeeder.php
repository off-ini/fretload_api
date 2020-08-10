<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'tag' => 'ADD_ROLE',
        ]);

        DB::table('permissions')->insert([
            'tag' => 'REMOVE_ROLE',
        ]);

        DB::table('permissions')->insert([
            'tag' => 'ADD_COURS',
        ]);

        DB::table('permissions')->insert([
            'tag' => 'EDITE_COURS',
        ]);
    }
}
