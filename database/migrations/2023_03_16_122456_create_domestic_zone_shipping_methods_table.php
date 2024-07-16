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
        Schema::create('domestic_zone_shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("domestic_zone_id");
            $table->unsignedBigInteger("shipping_method_id");
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
        Schema::dropIfExists('domestic_zone_shipping_methods');
    }
};
