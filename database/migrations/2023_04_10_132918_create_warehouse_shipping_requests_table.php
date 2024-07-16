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
        Schema::create('warehouse_shipping_requests', function (Blueprint $table) {
            $table->id();
            $table->string("reference_model");
            $table->unsignedBigInteger("reference_model_id");
            $table->unsignedBigInteger("warehouse_id");
            $table->string("tracking_id");
            $table->string("tracking_url")->nullable();
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
        Schema::dropIfExists('warehouse_shipping_requests');
    }
};
