<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecaudationAnouncedAndFinishDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preventas', function (Blueprint $table) {
            $table->date('start')->nullable();
            $table->date('announced_end')->nullable();
            $table->date('end')->nullable();
        });

        Schema::table('solicitud_adicion_preventas', function (Blueprint $table) {
            $table->date('start')->nullable();
            $table->date('announced_end')->nullable();
            $table->date('end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preventas', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('announced_end');
            $table->dropColumn('end');
        });

        Schema::table('solicitud_adicion_preventas', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('announced_end');
            $table->dropColumn('end');
        });
    }
}
