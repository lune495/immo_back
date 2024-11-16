<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfo2ToLocataires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locataires', function (Blueprint $table) {
            $table->string('lieu_naissance')->nullable();
            $table->date('date_naissance')->nullable();
            $table->date('date_delivrance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locataires', function (Blueprint $table) {
            $table->$table->dropColumn('lieu_naissance');
            $table->$table->dropColumn('date_naissance');
            $table->$table->dropColumn('date_delivrance');
        });
    }
}
