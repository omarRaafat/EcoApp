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
        Schema::table('order_vendor_shipping_warehouses', function (Blueprint $table) {
            $table->unsignedBigInteger('warehouse_city_id')->nullable();
            $table->foreign('warehouse_city_id')->references('id')->on('cities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_vendor_shipping_warehouses', function (Blueprint $table) {
            $table->dropColumn('warehouse_city_id');
        });
    }
};
