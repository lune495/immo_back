<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommissionAgenceToBienImmos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bien_immos', function (Blueprint $table) {
            //
            $table->float('commission_agence')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bien_immos', function (Blueprint $table) {
            //
            $table->dropColumn('commission_agence');
        });
    }
}
