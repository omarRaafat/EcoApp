<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('order_ships', function (Blueprint $table) {
            $table->tinyInteger('is_out_of_stock')->nullable();
        });
    }

    public function down()
    {
        Schema::table('order_ships', function (Blueprint $table) {
            $table->dropColumn('is_out_of_stock');
        });
    }
};