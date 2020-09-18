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
            'tag' => 'CREATE',
        ]);

        DB::table('permissions')->insert([
            'tag' => 'SELECT',
        ]);

        DB::table('permissions')->insert([
            'tag' => 'UPDATE',
        ]);

        DB::table('permissions')->insert([
            'tag' => 'DELETE',
        ]);
    }
}
