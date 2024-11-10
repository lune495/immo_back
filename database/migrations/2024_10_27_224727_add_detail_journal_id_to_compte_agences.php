<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailJournalIdToCompteAgences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compte_agences', function (Blueprint $table) {
            $table->unsignedBigInteger('detail_journal_id')->nullable();
            $table->foreign('detail_journal_id')->references('id')->on('detail_journals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compte_agences', function (Blueprint $table) {
            $table->dropColumn('detail_journal_id');
        });
    }
}
