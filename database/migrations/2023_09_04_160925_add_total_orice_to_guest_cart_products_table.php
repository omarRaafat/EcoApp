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
        Schema::table('guest_cart_products', function (Blueprint $table) {
            $table->double('total_weight' , 8 , 2)->nullable();
            $table->double('total_price' , 8 , 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guest_cart_products', function (Blueprint $table) {
            $table->dropColumn('total_weight');
            $table->dropColumn('total_price');
        });
    }
};
