<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompteCautionLocatairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_caution_locataires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('locataire_id')->nullable()->constrained()->references('id')->on('locataires');
            $table->integer('montant_compte')->default(0);
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
        Schema::dropIfExists('compte_caution_locataires');
    }
}
