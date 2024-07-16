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
            $table->double('delivery_fees')->nullable();
            $table->double('additional_kilo_price')->nullable();
            $table->double('cod_collect_fees')->nullable();
            $table->unsignedBigInteger('delivery_fees_covered_kilos')->nullable();
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
            $table->dropColumn('delivery_fees');
            $table->dropColumn('additional_kilo_price');
            $table->dropColumn('cod_collect_fees');
            $table->dropColumn('delivery_fees_covered_kilos');
        });
    }
};
