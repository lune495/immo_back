<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienImmosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bien_immos', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('nom_immeuble')->nullable();
            $table->text('description')->nullable();
            $table->string('adresse')->nullable();
            $table->unsignedBigInteger('proprietaire_id');
            $table->foreign('proprietaire_id')->nullable()->references('id')->on('proprietaires');
            $table->integer('nbr_etage')->nullable();
            $table->integer('nbr_total_appartement')->default(0);
            $table->integer('nbr_magasin')->nullable();
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
        Schema::dropIfExists('bien_immos');
    }
}
