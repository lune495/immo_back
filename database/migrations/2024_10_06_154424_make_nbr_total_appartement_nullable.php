<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNbrTotalAppartementNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bien_immos', function (Blueprint $table) {
            $table->integer('nbr_total_appartement')->nullable()->change();
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
            $table->integer('nbr_total_appartement')->default(0)->change();
        });
    }
}
