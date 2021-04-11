<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTelegramNotificationCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitud_adicion_preventas', function (Blueprint $table) {
            $table->boolean('sendTelegramNotification')->default(false);
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
            $table->dropColumn('sendTelegramNotification');
        });
    }
}
