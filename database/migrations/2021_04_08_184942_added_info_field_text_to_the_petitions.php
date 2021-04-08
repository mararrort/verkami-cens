<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedInfoFieldTextToThePetitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitud_adicion_preventas', function (Blueprint $table) {
            $table->text('info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solicitud_adicion_preventas', function (Blueprint $table) {
            $table->dropColumn('info');
        });
    }
}
