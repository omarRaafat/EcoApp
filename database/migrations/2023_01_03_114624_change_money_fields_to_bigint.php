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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('price')->change();
            $table->unsignedBigInteger('price_before_offer')->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('total')->change();
            $table->unsignedBigInteger('sub_total')->change();
            $table->unsignedBigInteger('vat')->change();
            $table->unsignedBigInteger('tax')->change();

        });
        Schema::table('order_products', function (Blueprint $table) {
            $table->unsignedBigInteger('total')->change();
            $table->unsignedBigInteger('unit_price')->change();

        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('total')->change();
            $table->unsignedBigInteger('sub_total')->change();
            $table->unsignedBigInteger('total_vat')->change();
            $table->unsignedBigInteger('total_tax')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bigint', function (Blueprint $table) {
            //
        });
    }
};
