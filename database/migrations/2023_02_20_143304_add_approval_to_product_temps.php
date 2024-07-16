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
        Schema::table('product_temps', function (Blueprint $table) {
            $table->enum('approval',['accepted','pending','refused'])->default('pending');
            $table->longText('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_temps', function (Blueprint $table) {
            $table->dropColumn('approval');
            $table->dropColumn('note');
        });
    }
};
