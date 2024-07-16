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
        Schema::create('vendor_warehouse_request_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("warehouse_request_id")->nullable();
            $table->unsignedBigInteger("product_id");
            $table->integer("qnt");
            $table->dateTime("mnfg_date")->nullable();
            $table->dateTime("expire_date")->nullable();
            $table->foreign("warehouse_request_id")->references('id')->on('vendor_warehouse_requests')->onDelete('cascade');
            $table->foreign("product_id")->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('vendor_warehouse_request_products');
    }
};
