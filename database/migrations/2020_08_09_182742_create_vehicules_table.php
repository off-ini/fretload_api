<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('libelle')->nullable();
            $table->string('matricule');
            $table->string('description')->nullable();
            $table->double('capacite')->nullable();
            $table->double('taille')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(0);
            $table->integer('type_vehicule_id')->unsigned();
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
        Schema::dropIfExists('vehicules');
    }
}
