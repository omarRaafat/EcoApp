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
        Schema::table('orders', function (Blueprint $table) {
            $table->double('vat_percentage',4,2)->default(0);
            $table->double('delivery_fees')->default(0);
            $table->double('discount')->default(0);

        });
        Schema::table('order_products', function (Blueprint $table) {
            $table->double('vat_percentage',4,2)->default(0);
            $table->double('discount')->default(0);
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->double('vat_percentage',4,2)->default(0);
            $table->double('delivery_fees')->default(0);
            $table->double('discount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
