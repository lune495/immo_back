<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailJournalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_journals', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->integer('entree');
            $table->string('sortie');
            $table->unsignedBigInteger('locataire_id');
            $table->foreign('locataire_id')->nullable()->references('id')->on('locataires');
            $table->unsignedBigInteger('journal_id');
            $table->foreign('journal_id')->nullable()->references('id')->on('journals');
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
        Schema::dropIfExists('detail_journals');
    }
}
