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
            $table->tinyInteger('payment_method');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('company_percentage');
            $table->bigInteger('company_profit');
            $table->bigInteger('vendor_amount');

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
            $table->dropColumn("payment_method");

        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('company_percentage');
            $table->dropColumn('company_profit');
            $table->dropColumn('vendor_amount');

        });
    }
};
