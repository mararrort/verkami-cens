<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTODO extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('t_o_d_o_s');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('t_o_d_o_s', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('text', 128);
            $table->enum('type', ['private', 'public', 'undecided']);

            $table->timestamps();
            $table->softDeletes();
        });
    }
}
