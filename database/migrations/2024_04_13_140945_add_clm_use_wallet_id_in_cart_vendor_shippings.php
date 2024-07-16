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
        Schema::table('cart_vendor_shippings', function (Blueprint $table) {
            $table->unsignedBigInteger("wallet_id")->nullable()->after('user_id');
            $table->double('total_products',15,3)->default(0)->after('wallet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_vendor_shippings', function (Blueprint $table) {
            $table->dropColumn('wallet_id');
            $table->dropColumn('total_products');
        });
    }
};
