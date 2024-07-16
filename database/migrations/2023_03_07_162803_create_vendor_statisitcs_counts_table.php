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
        Schema::create('vendor_statisitcs_counts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("vendor_id");
            $table->unsignedBigInteger("orders");
            $table->double("sales", 10, 2, true);
            $table->double("profits", 10, 2, true);
            $table->double("rates", 4, 2);
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
        Schema::dropIfExists('vendor_statisitcs_counts');
    }
};
