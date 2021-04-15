<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CascadeRemoveTheModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("presales", function (Blueprint $table) {
            $table
                ->foreign("editorial_id")
                ->references("id")
                ->on("editorials")
                ->onDelete("cascade")
                ->change();
        });
        Schema::table("petitions", function (Blueprint $table) {
            $table
                ->foreign("editorial_id")
                ->references("id")
                ->on("editorials")
                ->onDelete("cascade")
                ->change();

            $table
                ->foreign("presale_id")
                ->references("id")
                ->on("presales")
                ->onDelete("cascade")
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("presales", function (Blueprint $table) {
            $table->dropForeign(["editorial_id"]);
        });
        Schema::table("petitions", function (Blueprint $table) {
            $table->dropForeign(["editorial_id"]);
            $table->dropForeign(["presale_id"]);
        });
    }
}
