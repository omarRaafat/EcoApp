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
        Schema::table('vendor_wallets', function (Blueprint $table) {
            $table->bigInteger('balance')->default(0)->change()->comment('balance in halala');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_wallets', function (Blueprint $table) {
            $table->unsignedBigInteger('balance')->default(0)->change()->comment('balance in halala');
        });
    }
};
