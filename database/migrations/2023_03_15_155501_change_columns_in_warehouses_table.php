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
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('integration_key');
            $table->double('package_price', 12, 2)->default(0);
            $table->integer('package_covered_quantity')->nullable();
            $table->double('additional_unit_price', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->string("integration_key")->nullable()->unique();
            $table->dropColumn('package_price');
            $table->dropColumn('package_covered_quantity');
            $table->dropColumn('additional_unit_price');
        });
    }
};
