<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeMarchandiseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_marchandises')->insert([
            [
                'libelle' => 'Exceptionnelle',
                'default_image' => 'defaults/marchandise.png'
            ],
            [
                'libelle' => 'Sèche',
                'default_image' => 'defaults/marchandise.png'
            ],
            [
                'libelle' => 'Conditionnées',
                'default_image' => 'defaults/marchandise.png'
            ],
            [
                'libelle' => 'Conventionnelles',
                'default_image' => 'defaults/marchandise.png'
            ],
            [
                'libelle' => 'Dangereuses',
                'default_image' => 'defaults/marchandise.png'
            ],
            [
                'libelle' => 'Pondéreuses',
                'default_image' => 'defaults/marchandise.png'
            ],
            [
                'libelle' => 'Générales / Diverses',
                'default_image' => 'defaults/marchandise.png'
            ],
        ]);
    }
}
