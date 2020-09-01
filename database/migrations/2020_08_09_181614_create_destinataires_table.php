<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDestinatairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinataires', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('f_name');
            $table->string('email')->unique();
            $table->dateTime('naissance')->nullable();
            $table->char('sexe')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('adresse')->nullable();
            $table->string('photo')->nullable();
            $table->integer('status')->default(0);
            $table->integer('ville_id')->unsigned();
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
        Schema::dropIfExists('destinataires');
    }
}
