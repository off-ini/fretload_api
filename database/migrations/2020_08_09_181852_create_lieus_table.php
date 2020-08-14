<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLieusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('quartier')->nullable();
            $table->string('adresse')->nullable();
            $table->string('logitude')->nullable();
            $table->string('latitude')->nullable();
            $table->integer('ville_id')->unsigned();
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
        Schema::dropIfExists('adresses');
    }
}
