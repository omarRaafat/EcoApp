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
        Schema::table('transactions', function (Blueprint $table) {
            $table->double('base_delivery_fees')->nullable();
            $table->double('cod_collect_fees')->nullable();
            $table->double('packaging_fees')->nullable();
            $table->double('extra_weight_fees')->nullable();
            $table->unsignedBigInteger('shipping_method_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->double('base_delivery_fees');
            $table->double('cod_collect_fees');
            $table->double('packaging_fees');
            $table->double('extra_weight_fees');
            $table->unsignedBigInteger('shipping_method_id');
        });
    }
};
