<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(PaysTableSeeder::class);
        $this->call(VilleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RolesUserTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(PermissionRolesUserTableSeeder::class);
        $this->call(TypeMarchandiseTableSeeder::class);
        $this->call(TypeVehiculeTableSeeder::class);
        $this->call(ModePayementTableSeeder::class);
    }
}
