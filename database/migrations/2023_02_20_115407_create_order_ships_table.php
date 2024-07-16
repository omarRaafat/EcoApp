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
        Schema::create('order_ships', function (Blueprint $table) {
            $table->id();
            $table->string("reference_model");
            $table->unsignedBigInteger("reference_model_id");
            $table->string("gateway_order_id")->nullable();
            $table->string("gateway_tracking_id")->nullable();
            $table->string("gateway_tracking_url")->nullable();
            $table->json("extra_data")->nullable();
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
        Schema::dropIfExists('order_ships');
    }
};
