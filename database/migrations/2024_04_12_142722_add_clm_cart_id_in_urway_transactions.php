<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('urway_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger("user_id")->nullable()->after('id');
            $table->unsignedBigInteger("cart_id")->nullable()->after('transaction_id');
            $table->double('visa_amount',15,3)->default(0)->after('cart_id');
            $table->double('wallet_amount',15,3)->default(0)->after('visa_amount');
            $table->longText("response")->nullable()->after('customer_ip');

            DB::statement('ALTER TABLE urway_transactions MODIFY transaction_id BIGINT UNSIGNED NULL');
            DB::statement('ALTER TABLE urway_transactions MODIFY urway_payment_id VARCHAR(250) DEFAULT NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('urway_transactions', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('cart_id');
            $table->dropColumn('visa_amount');
            $table->dropColumn('wallet_amount');
            $table->dropColumn('response');
        });
    }
};
