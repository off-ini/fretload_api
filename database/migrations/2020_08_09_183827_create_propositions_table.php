<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propositions', function (Blueprint $table) {
            $table->increments('id');
            $table->double('montant_t')->nullable();
            $table->double('montant_p')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('is_mission')->default(false);
            $table->boolean('is_read')->default(false);
            $table->boolean('is_accept')->default(false);
            $table->dateTime('accepted_at')->nullable();
            $table->integer('annonce_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('proposition_reply_id')->unsigned()->nullable();
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
        Schema::dropIfExists('propositions');
    }
}
