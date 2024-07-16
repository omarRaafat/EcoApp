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
        Schema::table('order_vendor_shippings', function (Blueprint $table) {
            $table->float('base_shipping_fees')->nullable();
            $table->float('extra_shipping_fees')->nullable()->comment('for extra weight in another shipping methods else aramex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_vendor_shippings', function (Blueprint $table) {
            $table->dropColumn('base_shipping_fees');
            $table->dropColumn('extra_shipping_fees');
        });
    }
};
