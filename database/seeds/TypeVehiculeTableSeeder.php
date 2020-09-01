<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeVehiculeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_vehicules')->insert([
            [
                'libelle' => 'Camion-citerne',
                'default_image' => 'defaults/citerne.png'
            ],
            [
                'libelle' => 'Camion benne',
                'default_image' => 'defaults/benne.png'
            ],
            [
                'libelle' => 'Camion frigorifique',
                'default_image' => 'defaults/frigorifique.png'
            ],
            [
                'libelle' => 'Camion Ampliroll',
                'default_image' => 'defaults/ampliroll.png'
            ],
            [
                'libelle' => 'Camion plateau',
                'default_image' => 'defaults/plateau.png'
            ],
            [
                'libelle' => 'Camion porte char',
                'default_image' => 'defaults/porte-char.png'
            ],
            [
                'libelle' => 'Camion fourgon',
                'default_image' => 'defaults/fourgon.png'
            ],
            [
                'libelle' => 'Camion',
                'default_image' => 'defaults/camion.png'
            ]
        ]);
    }
}
