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
        Schema::table('cart_product', function (Blueprint $table) {
            $table->unsignedBigInteger('shipping_type_id')->nullable();
            $table->foreign('shipping_type_id')->references('id')->on('shipping_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropForeign(['shipping_type_id']);
            $table->dropColumn('shipping_type_id');
        });
    }
};
