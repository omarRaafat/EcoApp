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
        Schema::table('type_of_employees', function (Blueprint $table) {
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type_of_employees', function (Blueprint $table) {
            $table->dropColumn('vendor_id');
        });
    }
};
