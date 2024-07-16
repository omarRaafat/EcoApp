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
        Schema::table('tabby_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger("user_id")->nullable()->after('id');
            $table->unsignedBigInteger("cart_id")->nullable()->after('transaction_id');
            $table->double('visa_amount',15,3)->default(0)->after('cart_id');
            $table->double('wallet_amount',15,3)->default(0)->after('visa_amount');
            $table->longText("response")->nullable()->after('customer_ip');
            $table->longText("reqCallback")->nullable()->after('response');
            $table->string("statusCallback")->nullable()->after('reqCallback');
            $table->double('amountCallback',15,3)->default(0)->after('statusCallback');

            DB::statement('ALTER TABLE tabby_transactions MODIFY transaction_id BIGINT UNSIGNED NULL');
            DB::statement('ALTER TABLE tabby_transactions MODIFY tabby_payment_id VARCHAR(250) DEFAULT NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tabby_transactions', function (Blueprint $table) {
            //
        });
    }
};
