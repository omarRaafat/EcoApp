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
        Schema::table('countries', function (Blueprint $table) {
            $table->double("minimum_order_weight")->nullable();
            $table->double("maximum_order_weight")->nullable();
            $table->double("maximum_order_total")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn("minimum_order_weight");
            $table->dropColumn("maximum_order_weight");
            $table->dropColumn("maximum_order_total");
        });
    }
};
