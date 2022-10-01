<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBienIdToBienImmo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bien_immos', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('bien_id')->nullable();
            $table->foreign('bien_id')->references('id')->on('biens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bien_immos', function (Blueprint $table) {
            //
            // $table->dropForeign('bien_id');
            // $table->dropForeign(['bien_id']);
        });
    }
}
