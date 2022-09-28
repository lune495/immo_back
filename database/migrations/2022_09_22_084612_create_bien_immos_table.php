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
            $table->string('description');
            $table->string('adresse')->nullable();
            $table->string('montant');
            $table->unsignedBigInteger('type_bien_immo_id');
            $table->foreign('type_bien_immo_id')->references('id')->on('type_bien_immos');
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
