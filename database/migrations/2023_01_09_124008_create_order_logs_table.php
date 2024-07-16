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
        Schema::dropIfExists('order_steps');
        Schema::create('order_logs', function (Blueprint $table) {
            $table->id();
            $table->string('old_status');// registered,shipping_done,in_delivery,completed,canceled,refund
            $table->string('new_status');// registered,shipping_done,in_delivery,completed,canceled,refund
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('order_steps');
        Schema::dropIfExists('order_logs');
    }
};
