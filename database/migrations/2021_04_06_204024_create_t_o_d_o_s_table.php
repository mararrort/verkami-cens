<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTODOSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_o_d_o_s', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('text', 64);
            $table->enum('type', ['private', 'public', 'undecided']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_o_d_o_s');
    }
}
