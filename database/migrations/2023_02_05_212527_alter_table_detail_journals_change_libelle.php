<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDetailJournalsChangeLibelle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_journals', function (Blueprint $table) {
            //
             $table->string('libelle')->nullable()->change();
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_journals', function (Blueprint $table) {
            //
            $table->dropColumn('libelle');
        });
    }
}
