<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domestic_zones', function (Blueprint $table) {
            $table->unsignedInteger("days_from")->nullable();
            $table->unsignedInteger("days_to")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domestic_zones', function (Blueprint $table) {
            $table->dropColumn("days_from");
            $table->dropColumn("days_to");
        });
    }
};
