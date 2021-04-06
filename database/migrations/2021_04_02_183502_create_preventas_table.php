<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventas', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name');
            $table->unique('name');
            $table->string('url');
            $table->unique('url');
            $table->enum('state', ['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir']);
            $table->uuid('empresa_id');
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preventas');
    }
}
