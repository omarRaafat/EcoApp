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
            //
            $table->json('days')->nullable();
            $table->string('time_work_from')->nullable();
            $table->string('time_work_to')->nullable();

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
            //
            $table->dropColumn('days');
            $table->dropColumn('time_work_from');
            $table->dropColumn('time_work_to');
        });
    }
};
