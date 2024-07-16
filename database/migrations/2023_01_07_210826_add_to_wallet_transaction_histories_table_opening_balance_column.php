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
        Schema::table('wallet_transaction_histories', function (Blueprint $table) {
            $table->boolean("is_opening_balance")->default(false);
            $table->string("charging_type")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallet_transaction_histories', function (Blueprint $table) {
            $table->dropColumn("is_opening_balance");
            $table->dropColumn("charging_type");
        });
    }
};
