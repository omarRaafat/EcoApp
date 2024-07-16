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
            $table->unsignedBigInteger('guest_customer_id')->nullable();
            $table->foreign('guest_customer_id')->references('id')->on('guest_customers')->onDelete('cascade');
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
            $table->dropForeign(['guest_customer_id']);
            $table->dropColumn('guest_customer_id');
        });
    }
};
