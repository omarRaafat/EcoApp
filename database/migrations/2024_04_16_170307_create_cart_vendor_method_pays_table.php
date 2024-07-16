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
        Schema::create('cart_vendor_method_pays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cart_id")->nullable();
            $table->unsignedBigInteger("vendor_id")->nullable();
            $table->unsignedBigInteger("wallet_id")->nullable();
            $table->double('amount',15,3)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_vendor_method_pays');
    }
};
