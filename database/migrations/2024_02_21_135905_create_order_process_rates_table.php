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
        Schema::create('order_process_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('order_id')->unique();
            $table->unsignedBigInteger('shipping_type_id')->nullable();
            $table->integer('merchantInteraction')->default(0);
            $table->integer('storeOrganization')->default(0);
            $table->integer('productAvailability')->default(0);
            $table->integer('orderArrivalSpeed')->default(0);
            $table->integer('deliveryRepInteraction')->default(0);
            $table->integer('productSafetyAfterDelivery')->default(0);
            $table->integer('repResponseTime')->default(0);
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
        Schema::dropIfExists('order_process_rates');
    }
};
