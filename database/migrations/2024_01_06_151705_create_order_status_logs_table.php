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
        Schema::create('order_status_logs', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('order_id')->unsigned()->nullable();
            $table->BigInteger('order_vendor_shipping_id')->unsigned()->nullable();
            $table->string('status')->nullable();
            $table->BigInteger('created_by')->unsigned()->nullable();
            $table->string('by_guard')->nullable();
            $table->text('raison')->nullable();
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
        Schema::dropIfExists('order_status_logs');
    }
};
