<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBordoreauxToMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->string('code_livraison')->nullable()->after('code');
            $table->string('bordoreau_c')->nullable()->after('date_arriver_eff');
            $table->string('bordoreau_l')->nullable()->after('bordoreau_c');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('code_livraison');
            $table->dropColumn('bordoreau_c');
            $table->dropColumn('bordoreau_l');
        });
    }
}
