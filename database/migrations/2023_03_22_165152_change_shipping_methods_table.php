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
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->double('delivery_fees')->change();
            $table->double('additional_kilo_price')->change();
            $table->double('cod_collect_fees')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->double('delivery_fees', 12, 2)->nullable()->change();
            $table->double('additional_kilo_price', 9, 2)->nullable()->change();
            $table->double('cod_collect_fees', 9, 2)->nullable()->change();
        });
    }
};
