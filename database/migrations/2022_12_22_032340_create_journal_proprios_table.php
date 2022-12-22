<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalPropriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_proprios', function (Blueprint $table) {
            $table->id();
            $table->integer('entree');
            $table->string('sortie');
            $table->unsignedBigInteger('proprietaire_id');
            $table->foreign('proprietaire_id')->nullable()->references('id')->on('proprietaires');
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
        Schema::dropIfExists('journal_proprios');
    }
}
