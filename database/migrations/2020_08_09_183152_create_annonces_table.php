<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnoncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('title')->nullable();
            $table->string('body')->nullable();
            $table->string('payload')->nullable();
            $table->double('montant')->nullable();
            $table->double('montant_k')->nullable();
            $table->boolean('is_public')->default(true);
            $table->integer('marchandise_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('user_sigle_id')->nullable()->unsigned();
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
        Schema::dropIfExists('annonces');
    }
}
