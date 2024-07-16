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
        Schema::create('vendor_warehouse_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("vendor_id")->nullable();
            $table->string("status")->nullable();
            $table->string("created_by");
            $table->unsignedBigInteger("created_by_id");
            $table->dateTime("start_time")->nullable();
            $table->dateTime("end_time")->nullable();
            $table->foreign("vendor_id")->references('id')->on('users')->onDelete('cascade');
            $table->foreign("created_by_id")->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_warehouse_requests');
    }
};
