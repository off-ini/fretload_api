<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarchandisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marchandises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('libelle')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->double('poid')->nullable();
            $table->double('volume')->nullable();
            $table->integer('lieu_depart_id')->unsigned();
            $table->integer('lieu_arriver_id')->unsigned();
            $table->integer('destinataire_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marchandises');
    }
}
