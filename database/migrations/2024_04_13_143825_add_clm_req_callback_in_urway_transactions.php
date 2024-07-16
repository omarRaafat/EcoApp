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
        Schema::table('urway_transactions', function (Blueprint $table) {
            $table->longText("reqCallback")->nullable()->after('response');
            $table->string("statusCallback")->nullable()->after('reqCallback');
            $table->double('amountCallback',15,3)->default(0)->after('statusCallback');

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
            $table->dropColumn('reqCallback');
            $table->dropColumn('statusCallback');
            $table->dropColumn('amountCallback');
        });
    }
};
