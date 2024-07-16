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
            $table->double('total_shipping_fees' , 8 , 2)->nullable()->change();
            $table->integer('no_of_products')->nullable()->change();
         });
    }
};
