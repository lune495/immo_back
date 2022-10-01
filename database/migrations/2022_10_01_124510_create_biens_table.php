<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('adresse');
            $table->unsignedBigInteger('proprietaire_id');
            $table->foreign('proprietaire_id')->nullable()->references('id')->on('proprietaires');
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
        Schema::dropIfExists('biens');
    }
}
