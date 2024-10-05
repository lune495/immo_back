<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoSuppToStructures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('structures', function (Blueprint $table) {
            //
            $table->string('adresse_structure')->nullable();
            $table->string('numero_tel1_structure')->nullable();
            $table->string('numero_tel2_structure')->nullable();
            $table->string('numero_tel3_structure')->nullable();
            $table->string('site_structure')->nullable();
            $table->string('email_structure')->nullable();
            $table->string('instagram_structure')->nullable();
            $table->string('facebook_structure')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('structures', function (Blueprint $table) {
            $table->dropColumn('adresse_structure');
            $table->dropColumn('numero_tel1_structure');
            $table->dropColumn('numero_tel2_structure');
            $table->dropColumn('numero_tel3_structure');
            $table->dropColumn('site_structure');
            $table->dropColumn('email_structure');
            $table->dropColumn('instagram_structure');
            $table->dropColumn('facebook_structure');
        });
    }
}
