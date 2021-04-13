<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TelegramAddedPetitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telegram_chat', function (Blueprint $table) {
            $table->boolean('acceptedPetitions')->default(false);
            $table->boolean('createdPetitions')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telegram_chat', function (Blueprint $table) {
            $table->dropColumn('acceptedPetitions');
            $table->dropColumn('createdPetitions');
        });
    }
}
