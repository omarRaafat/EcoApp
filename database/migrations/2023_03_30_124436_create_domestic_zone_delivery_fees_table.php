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
        Schema::create('domestic_zone_delivery_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("domestic_zone_id");
            $table->double("weight_from");
            $table->double("weight_to");
            $table->double("delivery_fees");
            $table->softDeletes();
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
        Schema::dropIfExists('domestic_zone_delivery_fees');
    }
};
