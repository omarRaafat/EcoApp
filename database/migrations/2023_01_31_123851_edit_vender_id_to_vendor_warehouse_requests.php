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
        Schema::table('vendor_warehouse_requests', function (Blueprint $table) {
            $table->dropForeign('vendor_warehouse_requests_vendor_id_foreign'); 
            $table->foreign("vendor_id")->references('id')->on('vendors')->onDelete('cascade');
            // $table->string('status')->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_warehouse_requests', function (Blueprint $table) {
            //
        });
    }
};
