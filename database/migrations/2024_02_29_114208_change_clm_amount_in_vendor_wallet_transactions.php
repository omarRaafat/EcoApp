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
        Schema::table('vendor_wallet_transactions', function (Blueprint $table) {
            DB::statement('ALTER TABLE vendor_wallet_transactions MODIFY amount FLOAT(20,3)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_wallet_transactions', function (Blueprint $table) {
            //
        });
    }
};
