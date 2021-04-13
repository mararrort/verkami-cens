<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorEmpresaToEditorial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('empresas', 'editorials');
        Schema::table('preventas', function (Blueprint $table) {
            $table->dropForeign('preventas_empresa_id_foreign');
            $table->renameColumn('empresa_id', 'editorial_id');
            $table->foreign('editorial_id')->references('id')->on('editorials');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('editorials', 'empresas');
        Schema::table('preventas', function (Blueprint $table) {
            $table->dropForeign('preventas_editorial_id_foreign');
            $table->renameColumn('editorial_id', 'empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
    }
}
