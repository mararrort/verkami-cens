<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PetitionsImprovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solicitud_adicion_preventas', function (Blueprint $table) {
            $table->dropColumn('text');
            $table->dropColumn('solved');

            $table->uuid('presale_id')->nullable();
            $table->foreign('presale_id')->references('id')->on('preventas')->onUpdate('cascade')
            ->onDelete('cascade');

            $table->string('presale_name')->nullable();
            $table->string('presale_url')->nullable();

            $table->uuid('editorial_id')->nullable();
            $table->foreign('editorial_id')->references('id')->on('empresas')->onUpdate('cascade')
            ->onDelete('cascade');

            $table->string('editorial_name')->nullable();
            $table->string('editorial_url')->nullable();

            $table->enum('state', ['Recaudando', 'Pendiente de entrega', 'Parcialmente entregado', 'Entregado', 'Sin definir']);
            $table->boolean('late')->default(false);

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
        Schema::table('solicitud_adicion_preventas', function (Blueprint $table) {
            $table->text('text');
            $table->boolean('solved')->default(false);

            $table->dropForeign(['editorial_id']);
            $table->dropForeign(['presale_id']);
            $table->dropColumn(['presale_id', 'presale_name', 'presale_url', 'editorial_id', 'editorial_name', 'editorial_url', 'state', 'late', 'deleted_at']);
        });
    }
}
