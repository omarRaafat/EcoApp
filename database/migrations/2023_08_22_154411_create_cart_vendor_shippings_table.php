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
        Schema::create('cart_vendor_shippings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->unsignedBigInteger('to_city_id')->nullable();
            $table->foreign('to_city_id')->references('id')->on('cities');
            $table->string('city_name')->nullable();
            $table->string('to_city_name')->nullable();
            $table->unsignedBigInteger('shipping_type_id')->nullable();
            $table->foreign('shipping_type_id')->references('id')->on('shipping_types');
            $table->string('van_type')->nullable();
            $table->float('total_weight');
            $table->float('total_shipping_fees');
            $table->unsignedBigInteger('cart_id');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            // $table->unique(['cart_id', 'vendor_id']);
            $table->unsignedBigInteger('shipping_method_id')->nullable();
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods');
            $table->integer('user_id')->nullable();
            $table->integer('no_of_products')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_vendor_shippings');
    }
};
