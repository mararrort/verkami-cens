<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixTelegramId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telegram', function (Blueprint $table) {
            $table->bigInteger('id')->change();
        });

        Schema::table('telegram_chat', function (Blueprint $table) {
            $table->bigInteger('id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telegram', function (Blueprint $table) {
            $table->integer('id')->change();
        });

        Schema::table('telegram_chat', function (Blueprint $table) {
            $table->integer('id')->change();
        });
    }
}
