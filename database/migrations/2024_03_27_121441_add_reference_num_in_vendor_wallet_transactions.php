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
            $table->string('reference_num')->nullable()->after('status');
            $table->text('reason')->nullable()->after('reference_num');
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
