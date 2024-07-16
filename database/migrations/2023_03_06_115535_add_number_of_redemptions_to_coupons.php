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
        Schema::table('coupons', function (Blueprint $table) {
            $table->float('minimum_order_amount');
            $table->float('maximum_discount_amount');
            $table->float('number_of_redemptions')->default(0);

            $table->dropColumn('minimum_amount');
            $table->dropColumn('maximum_amount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('number_of_redemptions');
            $table->dropColumn('minimum_order_amount');
            $table->dropColumn('maximum_discount_amount');

            $table->float('minimum_amount');
            $table->float('maximum_amount');
        });
    }
};
