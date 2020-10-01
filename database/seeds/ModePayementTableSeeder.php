<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModePayementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mode_payements')->insert([
            [
                'libelle' => 'PayPal',
                'default_image' => 'defaults/paypal.png'
            ],
            [
                'libelle' => 'Cartes Bancaires',
                'default_image' => 'defaults/carte.png'
            ],
            [
                'libelle' => 'Flooz',
                'default_image' => 'defaults/flooz.png'
            ],
            [
                'libelle' => 'T-Money',
                'default_image' => 'defaults/tmoney.png'
            ],
        ]);
    }
}
