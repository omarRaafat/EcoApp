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
            $table->dropColumn('note');
            $table->dropColumn('reminder');
            $table->dropColumn('wallet_deduction');
            $table->dropColumn('use_wallet');
            $table->dropColumn('shipping_method_id');
            $table->dropColumn('wallet_id');

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
