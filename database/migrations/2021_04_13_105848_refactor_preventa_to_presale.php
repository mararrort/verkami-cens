<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorPreventaToPresale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('preventas', 'presales');
        Schema::table('presales', function (Blueprint $table) {
            $table->renameColumn('tarde', 'late');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('presales', 'preventas');
        Schema::table('preventas', function (Blueprint $table) {
            $table->renameColumn('late', 'tarde');
        });
    }
}
