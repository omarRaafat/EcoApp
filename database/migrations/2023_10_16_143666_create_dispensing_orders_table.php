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
        Schema::dropIfExists('dispensing_orders');
        Schema::create('dispensing_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('amount')->nullable();
            $table->unsignedBigInteger('initial_admin_id')->nullable();
            $table->unsignedBigInteger('final_admin_id')->nullable();
            $table->enum('type' , ['initial' , 'final' , 'done'])->nullable();
            $table->enum('status' , ['success' , 'fail' , 'cancel'])->nullable();
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
        Schema::dropIfExists('dispensing_orders');
    }
};
