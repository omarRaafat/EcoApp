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
        Schema::table('cart_vendor_shippings', function (Blueprint $table) {
            $table->unsignedBigInteger("delivery_warehouse_id")->nullable()->after('shipping_method_id');
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_vendor_shippings', function (Blueprint $table) {
            $table->dropColumn('delivery_warehouse_id');
        });
    }
};
