<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->double('montant');
            $table->dateTime('date_depart_pre');
            $table->dateTime('date_depart_eff')->nullable();
            $table->dateTime('date_arriver_pre');
            $table->dateTime('date_arriver_eff')->nullable();
            $table->integer('status')->default(0);
            $table->integer('marchandise_id')->unsigned();
            $table->integer('proposition_id')->unsigned();
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
        Schema::dropIfExists('missions');
    }
}
