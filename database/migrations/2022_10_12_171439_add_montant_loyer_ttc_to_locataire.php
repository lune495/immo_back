<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontantLoyerTtcToLocataire extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locataires', function (Blueprint $table) {
            //
            $table->decimal('montant_loyer_ttc', 12, 2)->default('0');
            $table->decimal('montant_loyer_ht', 12, 2)->default('0');
            $table->text('descriptif_loyer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locataires', function (Blueprint $table) {
            //
            $table->dropColumn('montant_loyer_ttc');
            $table->dropColumn('montant_loyer_ht');
            $table->dropColumn('descriptif_loyer');
        });
    }
}
