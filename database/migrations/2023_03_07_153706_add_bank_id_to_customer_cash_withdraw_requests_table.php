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
        Schema::table('customer_cash_withdraw_requests', function (Blueprint $table) {
            $table->dropColumn("bank_name");
            $table->unsignedBigInteger("bank_id")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_cash_withdraw_requests', function (Blueprint $table) {
            $table->dropColumn("bank_id");
            $table->string('bank_name')->nullable();
        });
    }
};
