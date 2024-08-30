<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocatairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locataires', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('nom');
            $table->string('prenom');
            $table->string('CNI')->nullable();
            $table->string('telephone');
            $table->decimal('montant_loyer_ttc', 12, 2)->default('0');
            $table->decimal('montant_loyer_ht', 12, 2)->default('0');
            $table->integer('cc')->default('0');
            $table->text('descriptif_loyer');
            $table->unsignedBigInteger('bien_immo_id');
            $table->foreign('bien_immo_id')->references('id')->on('bien_immos');
            $table->string("profession")->nullable();
            $table->string("adresse_profession")->nullable();
            $table->string("situation_matrimoniale")->nullable();
            $table->integer('restant_caution')->default(0);
            $table->integer('multipli')->nullable();
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
        Schema::dropIfExists('locataires');
    }
}
