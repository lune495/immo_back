<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepenseProprioIdToDetailJournals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_journals', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('depense_proprio_id')->nullable();
            $table->foreign('depense_proprio_id')->references('id')->on('depense_proprios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_journals', function (Blueprint $table) {
            $table->dropColumn('depense_proprio_id');
        });
    }
}
