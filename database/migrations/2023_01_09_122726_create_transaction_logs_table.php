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
        Schema::dropIfExists('transaction_steps');
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('old_status');// registered,shipping_done,in_delivery,completed,canceled,refund
            $table->string('new_status');// registered,shipping_done,in_delivery,completed,canceled,refund
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_steps');
        Schema::dropIfExists('transaction_logs');
    }
};
