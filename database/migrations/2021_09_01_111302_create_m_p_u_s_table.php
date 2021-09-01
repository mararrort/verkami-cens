<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPUSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_p_u_s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('presale_id');

            $table->foreign('presale_id')->references('id')->on('presales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_p_u_s');
    }
}
