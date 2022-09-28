<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProprioBienImmosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprio_bien_immos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proprietaire_id');
            $table->foreign('proprietaire_id')->references('id')->on('proprietaires');
            $table->unsignedBigInteger('bien_immo_id');
            $table->foreign('bien_immo_id')->references('id')->on('bien_immos');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('proprio_bien_immos');
    }
}
