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
        Schema::table('vendor_wallet_transactions', function (Blueprint $table) {
            $table->enum('status',['pending','completed'])->default('pending')->after('reference_id');
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
            $table->dropColumn('status');
        });
    }
};
